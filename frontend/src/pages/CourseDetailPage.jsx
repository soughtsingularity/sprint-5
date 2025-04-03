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
      let parsedCompleted = [];

      try {
        parsedCompleted = courseData.completed && typeof courseData.completed === "string"
          ? JSON.parse(courseData.completed)
          : Array.isArray(courseData.completed)
          ? courseData.completed
          : [];
      
        parsedCompleted = parsedCompleted.map((i) => parseInt(i));
      
      } catch (e) {
        console.warn("Error parsing completed chapters:", e);
        parsedCompleted = [];
      }
      

      setCourse(courseData);
      setCompleted(parsedCompleted);
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
    fetchCourse(); 
  }, [id]);
  

  useEffect(() => {
    if (!loading && course?.content && Array.isArray(completed)) {
      console.log("🚨 completed:", completed);
      console.log("📘 course length:", course.content.length);
  
      if (completed.length > 0) {
        const nextChapter = completed.length;
        console.log("➡️ Ir al capítulo:", nextChapter);
        if (nextChapter < course.content.length) {
          setChapterIndex(nextChapter);
        } else {
          setChapterIndex(course.content.length - 1);
        }
      } else {
        console.log("🔁 Sin capítulos completados. Ir al 0");
        setChapterIndex(0);
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
<div className="max-w-4xl mx-auto mt-12 px-6">
  <h1 className="text-3xl font-bold mb-4 text-gray-900">{course.title}</h1>
  <p className="mb-3 text-gray-700">{course.description}</p>

  {medal && (
    <p className="text-lg font-semibold mb-6 text-gray-800">
      Medalla: <span className="capitalize text-black">{medal}</span>
    </p>
  )}

  {user?.role === "user" && (
    <div className="mb-8">
      {isEnrolled ? (
        <button
          onClick={handleUnenroll}
          className="bg-red-600 text-white px-5 py-2 rounded hover:bg-red-700 transition"
        >
          Salir del curso
        </button>
      ) : (
        <button
          onClick={handleEnroll}
          className="bg-black text-white px-5 py-2 rounded hover:bg-gray-800 transition"
        >
          Inscribirme
        </button>
      )}
    </div>
  )}

  <div className="mb-10">
    <h2 className="text-2xl font-semibold mb-3 text-gray-800">{chapter.title}</h2>
    <p className="mb-6 text-gray-600">{chapter.description}</p>

    {chapter.videos?.map((video, i) => (
      <div key={i} className="border border-gray-300 rounded-xl p-5 shadow-sm bg-white mb-6">
        <h3 className="text-xl font-semibold text-gray-900">{video.title}</h3>
        <p className="text-sm text-gray-600 mb-3">{video.description}</p>
        <div className="aspect-video">
          <iframe
            className="w-full h-full rounded"
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
      <div className="w-full bg-gray-200 rounded h-4 mb-6 overflow-hidden">
        <div
          className="bg-gray-800 h-4 transition-all"
          style={{ width: `${progress || 0}%` }}
        ></div>
      </div>

      <div className="mb-8">
        <label className="inline-flex items-center text-gray-800">
          <input
            type="checkbox"
            className="form-checkbox h-5 w-5 text-black"
            checked={completed.includes(chapterIndex)}
            onChange={handleCompleteChapter}
            disabled={completed.includes(chapterIndex)}
          />
          <span className="ml-3 text-sm">
            {completed.includes(chapterIndex)
              ? "Capítulo completado"
              : "Marcar como completado"}
          </span>
        </label>
      </div>
    </>
  )}

  <div className="flex flex-col sm:flex-row justify-between gap-4 pb-16">
    <button
      disabled={chapterIndex === 0}
      onClick={() => setChapterIndex((prev) => prev - 1)}
      className={`px-5 py-2 rounded ${
        chapterIndex === 0
          ? "bg-gray-300 text-gray-500 cursor-not-allowed"
          : "bg-black text-white hover:bg-gray-800 transition"
      }`}
    >
      Anterior
    </button>

    {chapterIndex < course.content.length - 1 ? (
      <button
        onClick={() => setChapterIndex((prev) => prev + 1)}
        className="px-5 py-2 rounded bg-black text-white hover:bg-gray-800 transition"
      >
        Siguiente
      </button>
    ) : (
      user?.role === "user" &&
      completed.length === course.content.length && (
        <button
          onClick={() => navigate("/courses")}
          className="px-5 py-2 rounded bg-green-700 text-white hover:bg-green-800 transition"
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
