import { useEffect, useState } from "react";
import axios from "axios";
import { Link } from "react-router-dom";
import { useAuth } from "../contexts/AuthContext";
import { toast } from "react-toastify";

function CourseListPage() {
  const [courses, setCourses] = useState([]);
  const [loading, setLoading] = useState(true);
  const { user } = useAuth();
  const { token } = useAuth();

  useEffect(() => {
    axios
      .get("http://localhost:8000/api/courses")
      .then((res) => setCourses(res.data.data))
      .catch((err) => console.error("Error fetching courses:", err))
      .finally(() => setLoading(false));
  }, []);

  const handleDelete = async (courseId) => {
    if (!window.confirm("¿Estás seguro de que deseas eliminar este curso?")) return;

    try {
      await axios.delete(`http://localhost:8000/api/courses/${courseId}`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      setCourses((prev) => prev.filter((c) => c.id !== courseId));
    } catch (err) {
      console.error("Error al eliminar curso:", err);
      toast.error("No se pudo eliminar el curso");
    }
  };

  if (loading) return <p className="text-center mt-10 text-gray-500">Loading courses...</p>;

  return (
    <div className="max-w-4xl mx-auto mt-10 px-4">
      <div className="flex justify-between items-center mb-6 border-b pb-4">
        <h1 className="text-3xl font-bold text-gray-800">Cursos disponibles</h1>
        {user?.role === "admin" && (
          <Link
            to="/admin/courses/new"
            className="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 text-sm transition"
          >
            + Crear curso
          </Link>
        )}
      </div>
      <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
      {courses.map((course) => (
  <div
    key={course.id}
    className="bg-white border border-gray-200 rounded-xl shadow-sm p-5 hover:shadow-md transition"
  >
    <h2 className="text-xl font-semibold text-gray-900">{course.title}</h2>
    <p className="text-sm text-gray-600 mt-2">{course.description}</p>

    {/* Botones en línea para todos los usuarios */}
    <div className="mt-4 flex flex-wrap gap-2">
      <Link
        to={`/courses/${course.id}`}
        className="px-4 py-2 bg-gray-900 text-white rounded hover:bg-gray-700 text-sm transition"
      >
        Ver curso
      </Link>

      {user?.role === "admin" && (
        <>
          <Link
            to={`/admin/courses/${course.id}`}
            className="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 text-sm transition"
          >
            Editar
          </Link>
          <button
            onClick={() => handleDelete(course.id)}
            className="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm transition"
          >
            Eliminar
          </button>
        </>
      )}
    </div>
  </div>
))}

      </div>
    </div>
  );
}

export default CourseListPage;
