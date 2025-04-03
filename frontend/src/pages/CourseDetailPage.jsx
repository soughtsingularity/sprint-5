import { useParams, useNavigate } from "react-router-dom";
import { useEffect, useState } from "react";
import axios from "axios";
import { useAuth } from "../contexts/AuthContext";
import { toast } from "react-toastify";

function CourseDetailPage() {
  const { id } = useParams();
  const [course, setCourse] = useState(null);
  const [completed, setCompleted] = useState([]);
  const [loading, setLoading] = useState(true);
  const { user, token } = useAuth();
  const [isEnrolled, setIsEnrolled] = useState(false);
  const [chapterIndex, setChapterIndex] = useState(0);
  const [medal, setMedal] = useState(null);
  const [progress, setProgress] = useState(null); // null para detectar carga completa
  const navigate = useNavigate();

  const fetchCourse = async () => {
    try {
      const res = await axios.get(`http://localhost:8000/api/courses/${id}`, {
        headers: { Authorization: `Bearer ${token}` },
      });

      const courseData = res.data.data;

      setCourse(courseData);
      setCompleted(courseData.completed || []);
      setProgress(courseData.progress ?? 0);
      setMedal(courseData.medal || null);
              

      if (user && courseData.users) {
        const enrolled = courseData.users.some((u) => u.id === user.id);
        setIsEnrolled(enrolled);
      }

    } catch (err) {
      console.error("Error loading course:", err);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    if (token) fetchCourse();
  }, [id, token]);

  useEffect(() => {
    if (!loading && course?.content && completed) {
      const nextChapter = completed.length;
      if (nextChapter < course.content.length) {
        setChapterIndex(nextChapter);
      } else {
        setChapterIndex(course.content.length - 1);
      }
    }
  }, [completed, course, loading]);

  if (loading || course === null || progress === null || !course.content || !course.content[chapterIndex])
    return <p className="text-center mt-10">Cargando curso...</p>;

  const chapter = course.content[chapterIndex];

  const handleEnroll = async () => {
    try {
      await axios.post(
        `http://localhost:8000/api/courses/${course.id}/enroll`,
        {},
        { headers: { Authorization: `Bearer ${token}` } }
      );
      toast.success("Te has inscrito al curso");
      setIsEnrolled(true);
      await fetchCourse(); // <--- recargar estado del curso
    } catch (err) {
      toast.error("Error al inscribirte");
    }
  };
  
  const handleUnenroll = async () => {
    try {
      await axios.post(
        `http://localhost:8000/api/courses/${course.id}/unenroll`,
        {},
        { headers: { Authorization: `Bearer ${token}` } }
      );
      toast.success("Te has desinscrito del curso");
      setIsEnrolled(false);
      await fetchCourse(); // <--- recargar estado
    } catch (err) {
      toast.error("Error al desinscribirte");
    }
  };
  

  const handleCompleteChapter = async () => {
    try {
      const res = await axios.post(
        `http://localhost:8000/api/courses/${id}/chapters/${chapterIndex}/complete`,
        {},
        { headers: { Authorization: `Bearer ${token}` } }
      );

      toast.success("Capítulo completado 🎉");

      setCompleted(res.data.completed_chapters);
      setProgress(res.data.progress);

    } catch (err) {
      console.error("Error al marcar capítulo como completado:", err);
    }
  };

  return (
    <div className="max-w-4xl mx-auto mt-10">
      <h1 className="text-3xl font-bold mb-4">{course.title}</h1>
      <p className="mb-2 text-gray-600">{course.description}</p>

      {medal && (
        <p className="text-lg font-semibold mb-4">
          Medalla: <span className="text-green-700 capitalize">{medal}</span>
        </p>
      )}

      {user?.role === "user" && (
        <div className="mb-6">
          {isEnrolled ? (
            <button
              onClick={handleUnenroll}
              className="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600"
            >
              Salir del curso
            </button>
          ) : (
            <button
              onClick={handleEnroll}
              className="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600"
            >
              Inscribirme
            </button>
          )}
        </div>
      )}

      <div className="mb-10">
        <h2 className="text-xl font-semibold mb-2">{chapter.title}</h2>
        <p className="mb-4 text-gray-600">{chapter.description}</p>

        {chapter.videos?.map((video, i) => (
          <div key={i} className="border rounded p-4 shadow mb-6">
            <h3 className="text-lg font-semibold">{video.title}</h3>
            <p className="text-sm text-gray-500">{video.description}</p>
            <div className="mt-2 aspect-video">
              <iframe
                className="w-full h-full"
                src={video.url.replace("watch?v=", "embed/")}
                frameBorder="0"
                allowFullScreen
              ></iframe>
            </div>
          </div>
        ))}
      </div>

      {user?.role === "user" && (
        <>
          <div className="w-full bg-gray-200 rounded h-4 mb-6">
            <div
              className="bg-green-500 h-4 rounded"
              style={{
                width: `${progress || 0}%`,
                transition: "width 0.3s",
              }}
            ></div>
          </div>

          <div className="mt-4 mb-6">
            <label className="inline-flex items-center">
              <input
                type="checkbox"
                className="form-checkbox h-5 w-5 text-blue-600"
                checked={completed.includes(chapterIndex)}
                onChange={handleCompleteChapter}
                disabled={completed.includes(chapterIndex)}
              />
              <span className="ml-2 text-sm">
                {completed.includes(chapterIndex)
                  ? "Capítulo completado"
                  : "Marcar como completado"}
              </span>
            </label>
          </div>
        </>
      )}

      <div className="flex flex-col sm:flex-row justify-between gap-4 mt-10 pb-16">
        <button
          disabled={chapterIndex === 0}
          onClick={() => setChapterIndex((prev) => prev - 1)}
          className={`px-4 py-2 rounded ${
            chapterIndex === 0
              ? "bg-gray-300 text-gray-500 cursor-not-allowed"
              : "bg-blue-600 text-white hover:bg-blue-700"
          }`}
        >
          Anterior
        </button>

        {chapterIndex < course.content.length - 1 ? (
          <button
            onClick={() => setChapterIndex((prev) => prev + 1)}
            className="px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700"
          >
            Siguiente
          </button>
        ) : (
          user?.role === "user" && completed.length === course.content.length && (
            <button
              onClick={() => navigate("/courses")}
              className="px-4 py-2 rounded bg-green-600 text-white hover:bg-green-700"
            >
              🎉 Completar curso
            </button>
          )
        )}
      </div>
    </div>
  );
}

export default CourseDetailPage;
