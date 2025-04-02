import { useParams } from "react-router-dom";
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
  


  useEffect(() => {
    axios
      .get(`http://localhost:8000/api/courses/${id}`)
      .then((res) => {
        console.log("Datos recibidos del curso:", res.data.data);
        setCourse(res.data.data);
        if (user && res.data.data.users) {
          const enrolled = res.data.data.users.some((u) => u.id === user.id);
          setIsEnrolled(enrolled);
        }
        setCompleted([]);
      })
      .catch((err) => console.error("Error loading course:", err))
      .finally(() => setLoading(false));
  }, [id, user]);
  

  if (loading) return <p className="text-center mt-10">Cargando curso...</p>;
  if (!course) return <p className="text-center mt-10">Curso no encontrado</p>;

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
    } catch (err) {
      toast.error("Error al desinscribirte");
    }
  };
  
  

  return (
    <div className="max-w-4xl mx-auto mt-10">
      <h1 className="text-3xl font-bold mb-4">{course.title}</h1>
      <p className="mb-6 text-gray-600">{course.description}</p>
      {user && user.role === "user" && (
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
  <div className="mt-4">
    <label className="inline-flex items-center">
      <input
        type="checkbox"
        className="form-checkbox h-5 w-5 text-blue-600"
        checked={completed.includes(chapterIndex)}
        onChange={() => {
          axios.post(
            `http://localhost:8000/api/courses/${id}/chapters/${chapterIndex}/complete`,
            { chapterIndex },
            { headers: { Authorization: `Bearer ${token}` } }
          )
          .then(() => {
            setCompleted((prev) => [...prev, chapterIndex]);
          })
          .catch((err) => {
            console.error("Error al marcar capítulo como completado:", err);
          });
        }}
      />
      <span className="ml-2 text-sm">Marcar como completado</span>
    </label>
  </div>
)}



      <div className="flex justify-between mt-6">
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

        <button
          disabled={chapterIndex === course.content.length - 1}
          onClick={() => setChapterIndex((prev) => prev + 1)}
          className={`px-4 py-2 rounded ${
            chapterIndex === course.content.length - 1
              ? "bg-gray-300 text-gray-500 cursor-not-allowed"
              : "bg-blue-600 text-white hover:bg-blue-700"
          }`}
        >
          Siguiente
        </button>
      </div>
    </div>
  );
}

export default CourseDetailPage;
