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
      toast.success("Curso eliminado");
      setCourses((prev) => prev.filter((c) => c.id !== courseId));
    } catch (err) {
      console.error("Error al eliminar curso:", err);
      toast.error("No se pudo eliminar el curso");
    }
  };

  if (loading) return <p className="text-center mt-10">Loading courses...</p>;

  return (
    <div className="max-w-4xl mx-auto mt-10">
      <div className="flex justify-between items-center mb-6">
        <h1 className="text-2xl font-bold">Available Courses</h1>
        {user?.role === "admin" && (
          <Link
            to="/admin/courses/new"
            className="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm"
          >
            + Crear curso
          </Link>
        )}
      </div>
      <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
        {courses.map((course) => (
          <div key={course.id} className="border rounded p-4 shadow">
            <h2 className="text-lg font-semibold">{course.title}</h2>
            <p className="text-sm text-gray-600 mt-1">{course.description}</p>
            <Link
              to={`/courses/${course.id}`}
              className="inline-block mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 text-sm"
            >
              Ver curso
            </Link>
            {user?.role === "admin" && (
            <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between mt-4 space-y-2 sm:space-y-0 sm:space-x-2">
              <Link
                to={`/admin/courses/${course.id}`}
                className="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm"
              >
                Editar
              </Link>
              <button
                onClick={() => handleDelete(course.id)}
                className="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm"
              >
                Eliminar
              </button>
            </div>
          )}

          </div>
          
        ))}
      </div>
    </div>
  );
}

export default CourseListPage;

