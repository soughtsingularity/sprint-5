import { useAuth } from "../contexts/AuthContext";
import { useEffect, useState } from "react";
import axios from "axios";

function UserDashboardPage() {
  const { token, user } = useAuth();
  const [profile, setProfile] = useState(null);

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
            className="border p-4 rounded shadow mb-4 bg-white"
          >
            <h3 className="text-lg font-semibold">{course.title}</h3>
            <p className="text-sm text-gray-600">Progreso: {course.progress}%</p>
            <p className="text-sm text-gray-600">Medalla: {course.medal}</p>
          </div>
        ))
      ) : (
        <p>No estás inscrito en ningún curso.</p>
      )}
    </div>
  );
}

export default UserDashboardPage;
