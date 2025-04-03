import { useAuth } from "../contexts/AuthContext";
import { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import axios from "axios";
import { toast } from "react-toastify";

function UserDashboardPage() {
  const { token, user, logout } = useAuth();
  const [profile, setProfile] = useState(null);
  const navigate = useNavigate();

  useEffect(() => {
    if (!user) return;

    axios
      .get(`http://localhost:8000/api/users/${user.id}`, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      })
      .then((res) => {
        console.log("Perfil recibido:", res.data);
        setProfile(res.data.data);
      })
      .catch((err) => console.error("Error cargando perfil:", err));
  }, [user, token]);

  const handleDeleteAccount = async () => {
    if (!window.confirm("¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.")) return;

    try {
      await axios.delete(`http://localhost:8000/api/users/${user.id}`, {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });

      toast.success("Cuenta eliminada con éxito");
      logout();
      navigate("/");
    } catch (err) {
      console.error("Error al eliminar cuenta:", err);
      toast.error("No se pudo eliminar la cuenta");
    }
  };

  if (!profile) return <p className="text-center mt-10 text-gray-500">Cargando perfil...</p>;

  return (
    <div className="max-w-3xl mx-auto mt-12 px-6">
      <h1 className="text-3xl font-bold mb-6 text-gray-800">Mi Perfil</h1>

      <div className="bg-white border border-gray-300 rounded-lg shadow-sm p-6 mb-8">
        <p className="text-gray-700 mb-2"><strong>Usuario:</strong> {profile.username}</p>
        <p className="text-gray-700"><strong>Email:</strong> {profile.email}</p>
      </div>

      <h2 className="text-2xl font-semibold mb-4 text-gray-800">Mis Cursos</h2>
      {profile.courses?.length > 0 ? (
        profile.courses.map((course) => (
          <div
            key={course.id}
            onClick={() => navigate(`/courses/${course.id}`)}
            className="border border-gray-200 p-5 rounded-xl shadow-sm mb-5 bg-white cursor-pointer hover:bg-gray-50 transition"
          >
            <h3 className="text-xl font-semibold text-gray-900">{course.title}</h3>
            <p className="text-sm text-gray-600 mb-2">Progreso: {course.progress}%</p>
            <div className="w-full bg-gray-200 rounded h-3 mb-2">
              <div
                className="bg-gray-800 h-3 rounded"
                style={{ width: `${course.progress}%`, transition: "width 0.3s" }}
              ></div>
            </div>
            <p className="text-sm text-gray-600">Medalla: {course.medal || "Sin medalla"}</p>
          </div>
        ))
      ) : (
        <p className="text-gray-600">No estás inscrito en ningún curso.</p>
      )}

      <button
        onClick={handleDeleteAccount}
        className="mt-8 bg-red-600 text-white px-5 py-2 rounded hover:bg-red-700 transition"
      >
        Eliminar cuenta
      </button>
    </div>
  );
}

export default UserDashboardPage;

