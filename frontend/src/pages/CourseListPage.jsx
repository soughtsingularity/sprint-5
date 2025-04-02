import { useEffect, useState } from "react";
import axios from "axios";
import { Link } from "react-router-dom";
import { useAuth } from "../contexts/AuthContext";

function CourseListPage() {
  const [courses, setCourses] = useState([]);
  const [loading, setLoading] = useState(true);
  const { user } = useAuth();

  useEffect(() => {
    axios
      .get("http://localhost:8000/api/courses")
      .then((res) => setCourses(res.data.data))
      .catch((err) => console.error("Error fetching courses:", err))
      .finally(() => setLoading(false));
  }, []);

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
          </div>
        ))}
      </div>
    </div>
  );
}

export default CourseListPage;

