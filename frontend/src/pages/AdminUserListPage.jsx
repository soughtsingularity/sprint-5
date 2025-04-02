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

  if (loading) return <p className="text-center mt-10">Cargando usuarios...</p>;

  return (
    <div className="max-w-5xl mx-auto mt-10">
      <h1 className="text-2xl font-bold mb-6">Usuarios registrados</h1>

      {users.map((user) => (
        <div key={user.id} className="border rounded p-4 mb-6 shadow">
          <h2 className="text-lg font-semibold mb-1">{user.username}</h2>
          <p className="text-sm text-gray-600">{user.email}</p>

          <h3 className="mt-4 text-md font-medium">Cursos inscritos:</h3>
          {user.courses?.length > 0 ? (
            <ul className="list-disc ml-6">
              {user.courses.map((course) => (
                <li key={course.id}>
                  <span className="font-semibold">{course.title}</span> - 
                  Progreso: {course.progress}% - 
                  Medalla: {course.medal}
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
