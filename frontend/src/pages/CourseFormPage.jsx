import { useState, useEffect } from "react";
import { useParams, useNavigate } from "react-router-dom";
import axios from "axios";
import { useAuth } from "../contexts/AuthContext";
import { toast } from "react-toastify";

function CourseFormPage() {
  const { id } = useParams(); 
  const navigate = useNavigate();
  const { token } = useAuth();
  const [title, setTitle] = useState("");
  const [description, setDescription] = useState("");
  const [content, setContent] = useState([
    {
      title: "",
      description: "",
      videos: [{ title: "", description: "", url: "" }],
    },
  ]);

  useEffect(() => {
    if (!id) return;

    axios
      .get(`http://localhost:8000/api/courses/${id}`, {
        headers: { Authorization: `Bearer ${token}` },
      })
      .then((res) => {
        const data = res.data.data;
        setTitle(data.title);
        setDescription(data.description);
        setContent(data.content);
      })
      .catch((err) => {
        toast.error("Error al cargar el curso");
        console.error(err);
      });
  }, [id, token]);

  const handleAddChapter = () => {
    setContent([
      ...content,
      { title: "", description: "", videos: [{ title: "", description: "", url: "" }] },
    ]);
  };

  const handleRemoveChapter = (chapterIndex) => {
    setContent(content.filter((_, i) => i !== chapterIndex));
  };

  const handleChapterChange = (index, field, value) => {
    const updated = [...content];
    updated[index][field] = value;
    setContent(updated);
  };

  const handleAddVideo = (chapterIndex) => {
    const updated = [...content];
    updated[chapterIndex].videos.push({ title: "", description: "", url: "" });
    setContent(updated);
  };

  const handleRemoveVideo = (chapterIndex, videoIndex) => {
    const updated = [...content];
    updated[chapterIndex].videos.splice(videoIndex, 1);
    setContent(updated);
  };

  const handleVideoChange = (chapterIndex, videoIndex, field, value) => {
    const updated = [...content];
    updated[chapterIndex].videos[videoIndex][field] = value;
    setContent(updated);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();
    const payload = { title, description, content };
    const url = id
      ? `http://localhost:8000/api/courses/${id}`
      : `http://localhost:8000/api/courses`;
    const method = id ? "put" : "post";

    try {
      await axios[method](url, payload, {
        headers: { Authorization: `Bearer ${token}` },
      });
      toast.success(id ? "Curso actualizado" : "Curso creado con éxito");
      navigate("/courses");
    } catch (err) {
      toast.error("Error al guardar el curso");
      console.error(err);
    }
  };

  const handleDelete = async () => {
    if (!window.confirm("¿Seguro que quieres eliminar este curso?")) return;
  
    try {
      await axios.delete(`http://localhost:8000/api/courses/${id}`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      toast.success("Curso eliminado");
      navigate("/courses");
    } catch (err) {
      console.error("Error al eliminar curso:", err);
      toast.error("No se pudo eliminar el curso");
    }
  };
  

  return (
<div className="max-w-4xl mx-auto mt-12 px-6">
  <h1 className="text-3xl font-bold mb-8 text-gray-800">
    {id ? "Editar curso" : "Crear nuevo curso"}
  </h1>

  <form onSubmit={handleSubmit} className="space-y-8">
    <input
      type="text"
      placeholder="Título del curso"
      className="w-full p-3 border border-gray-300 rounded bg-gray-50 text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-700"
      value={title}
      onChange={(e) => setTitle(e.target.value)}
      required
    />
    <textarea
      placeholder="Descripción del curso"
      className="w-full p-3 border border-gray-300 rounded bg-gray-50 text-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-700"
      value={description}
      onChange={(e) => setDescription(e.target.value)}
      required
    />

    {content.map((chapter, i) => (
      <div key={i} className="border border-gray-300 rounded-lg p-5 space-y-4 bg-white shadow-sm">
        <h2 className="font-semibold text-lg text-gray-800">Capítulo {i + 1}</h2>
        <input
          type="text"
          placeholder="Título del capítulo"
          className="w-full p-2 border border-gray-300 rounded bg-gray-50 focus:outline-none"
          value={chapter.title}
          onChange={(e) => handleChapterChange(i, "title", e.target.value)}
          required
        />
        <textarea
          placeholder="Descripción del capítulo"
          className="w-full p-2 border border-gray-300 rounded bg-gray-50 focus:outline-none"
          value={chapter.description}
          onChange={(e) => handleChapterChange(i, "description", e.target.value)}
          required
        />

        <div className="space-y-3">
          {chapter.videos.map((video, j) => (
            <div key={j} className="space-y-2 bg-gray-50 p-4 rounded border border-gray-200">
              <input
                type="text"
                placeholder="Título del vídeo"
                className="w-full p-2 border border-gray-300 rounded bg-white focus:outline-none"
                value={video.title}
                onChange={(e) => handleVideoChange(i, j, "title", e.target.value)}
                required
              />
              <input
                type="text"
                placeholder="Descripción del vídeo"
                className="w-full p-2 border border-gray-300 rounded bg-white focus:outline-none"
                value={video.description}
                onChange={(e) => handleVideoChange(i, j, "description", e.target.value)}
              />
              <input
                type="url"
                placeholder="URL del vídeo"
                className="w-full p-2 border border-gray-300 rounded bg-white focus:outline-none"
                value={video.url}
                onChange={(e) => handleVideoChange(i, j, "url", e.target.value)}
                required
              />
              <button
                type="button"
                onClick={() => handleRemoveVideo(i, j)}
                className="text-sm text-red-600 hover:underline"
              >
                Eliminar vídeo
              </button>
            </div>
          ))}

          <button
            type="button"
            onClick={() => handleAddVideo(i)}
            className="text-sm text-gray-700 hover:text-black"
          >
            + Añadir vídeo
          </button>
        </div>

        <button
          type="button"
          onClick={() => handleRemoveChapter(i)}
          className="text-sm text-red-600 hover:underline"
        >
          Eliminar capítulo
        </button>
      </div>
    ))}

    <button
      type="button"
      onClick={handleAddChapter}
      className="bg-black text-white px-4 py-2 rounded hover:bg-gray-800 transition"
    >
      + Añadir capítulo
    </button>

    <div className="flex flex-col sm:flex-row sm:justify-end gap-4 mt-6">
      <button
        type="submit"
        className="bg-green-700 text-white px-6 py-2 rounded hover:bg-green-800 transition"
      >
        {id ? "Actualizar curso" : "Crear curso"}
      </button>
      {id && (
        <button
          type="button"
          onClick={handleDelete}
          className="bg-red-600 text-white px-6 py-2 rounded hover:bg-red-700 transition"
        >
          Eliminar curso
        </button>
      )}
    </div>
  </form>
</div>

  );
}

export default CourseFormPage;

