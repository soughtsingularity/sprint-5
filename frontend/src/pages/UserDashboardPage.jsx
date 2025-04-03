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

  if (!profile) return <p className="text-center mt-10">Cargando perfil...</p>;

  return (
    <div className="max-w-3xl mx-auto mt-10 px-4">
      <h1 className="text-2xl font-bold mb-4">Mi Perfil</h1>
      <p><strong>Username:</strong> {profile.username}</p>
      <p><strong>Email:</strong> {profile.email}</p>

      <h2 className="text-xl font-semibold mt-6 mb-2">Mis Cursos</h2>
      {profile.courses?.length > 0 ? (
        profile.courses.map((course) => (
        <div
          key={course.id}
          onClick={() => navigate(`/courses/${course.id}`)}
          className="border p-4 rounded shadow mb-4 bg-white cursor-pointer hover:bg-gray-50 transition"
        >
          <h3 className="text-lg font-semibold">{course.title}</h3>
          <p className="text-sm text-gray-600 mb-2">Progreso: {course.progress}%</p>
          <div className="w-full bg-gray-200 rounded h-4 mb-2">
            <div
              className="bg-green-500 h-4 rounded"
              style={{ width: `${course.progress}%`, transition: "width 0.3s" }}
            ></div>
          </div>
          <p className="text-sm text-gray-600">Medalla: {course.medal || "Sin medalla"}</p>
          </div>
        ))
      ) : (
        <p>No estás inscrito en ningún curso.</p>
      )}


      <button
        onClick={handleDeleteAccount}
        className="mt-6 bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700"
      >
        Eliminar cuenta
      </button>
    </div>
  );
}

export default UserDashboardPage;
