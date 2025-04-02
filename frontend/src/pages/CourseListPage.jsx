import { useEffect, useState } from "react";
import axios from "axios";

function CourseListPage() {
  const [courses, setCourses] = useState([]);
  const [loading, setLoading] = useState(true);

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
      <h1 className="text-2xl font-bold mb-6 text-center">Available Courses</h1>
      <div className="grid grid-cols-1 sm:grid-cols-2 gap-6">
        {courses.map((course) => (
          <div key={course.id} className="border rounded p-4 shadow">
            <h2 className="text-lg font-semibold">{course.title}</h2>
            <p className="text-sm text-gray-600 mt-1">{course.description}</p>
          </div>
        ))}
      </div>
    </div>
  );
}

export default CourseListPage;
