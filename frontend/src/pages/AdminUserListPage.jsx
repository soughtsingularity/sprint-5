import { useEffect, useState } from "react";
import axios from "axios";
import { useAuth } from "../contexts/AuthContext";

function AdminUserListPage() {
  const { token } = useAuth();
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios.get("http://localhost:8000/api/users", {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })
    .then((res) => {
      console.log("Usuarios:", res.data.data);
      setUsers(res.data.data);
    })
    .catch((err) => console.error("Error al obtener usuarios:", err))
    .finally(() => setLoading(false));
  }, [token]);

  if (loading) return <p className="text-center mt-10 text-gray-500">Cargando usuarios...</p>;

  return (
    <div className="max-w-5xl mx-auto mt-12 px-6">
      <h1 className="text-3xl font-bold mb-8 text-gray-800">Usuarios registrados</h1>

      {users.map((user) => (
        <div
          key={user.id}
          className="border border-gray-300 rounded-lg p-6 mb-6 shadow-sm bg-white"
        >
          <h2 className="text-xl font-semibold text-gray-900 mb-1">{user.username}</h2>
          <p className="text-sm text-gray-600 mb-3">{user.email}</p>

          <h3 className="text-md font-medium text-gray-800 mb-2">Cursos inscritos:</h3>
          {user.courses?.length > 0 ? (
            <ul className="list-disc ml-6 text-sm text-gray-700 space-y-1">
              {user.courses.map((course) => (
                <li key={course.id}>
                  <span className="font-semibold text-gray-900">{course.title}</span> — Progreso: {course.progress}% — Medalla: {course.medal || "Sin medalla"}
                </li>
              ))}
            </ul>
          ) : (
            <p className="text-sm text-gray-500">No inscrito en cursos.</p>
          )}
        </div>
      ))}
    </div>
  );
}

export default AdminUserListPage;
