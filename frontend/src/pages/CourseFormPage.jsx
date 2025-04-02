import { useState, useEffect } from "react";
import { useParams, useNavigate } from "react-router-dom";
import axios from "axios";
import { useAuth } from "../contexts/AuthContext";
import { toast } from "react-toastify";

function CourseFormPage() {
  const { id } = useParams(); // Si existe, estamos editando
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

  return (
    <div className="max-w-4xl mx-auto mt-10">
      <h1 className="text-2xl font-bold mb-4">
        {id ? "Editar curso" : "Crear nuevo curso"}
      </h1>
      <form onSubmit={handleSubmit} className="space-y-6">
        <input
          type="text"
          placeholder="Título del curso"
          className="w-full p-2 border rounded"
          value={title}
          onChange={(e) => setTitle(e.target.value)}
          required
        />
        <textarea
          placeholder="Descripción del curso"
          className="w-full p-2 border rounded"
          value={description}
          onChange={(e) => setDescription(e.target.value)}
          required
        />

        {content.map((chapter, i) => (
          <div key={i} className="border p-4 rounded space-y-4 bg-gray-50">
            <h2 className="font-semibold text-lg">Capítulo {i + 1}</h2>
            <input
              type="text"
              placeholder="Título del capítulo"
              className="w-full p-2 border rounded"
              value={chapter.title}
              onChange={(e) => handleChapterChange(i, "title", e.target.value)}
              required
            />
            <textarea
              placeholder="Descripción del capítulo"
              className="w-full p-2 border rounded"
              value={chapter.description}
              onChange={(e) => handleChapterChange(i, "description", e.target.value)}
              required
            />
            <div className="space-y-2">
              {chapter.videos.map((video, j) => (
                <div key={j} className="space-y-1 bg-white p-2 rounded shadow">
                  <input
                    type="text"
                    placeholder="Título del vídeo"
                    className="w-full p-1 border rounded"
                    value={video.title}
                    onChange={(e) => handleVideoChange(i, j, "title", e.target.value)}
                    required
                  />
                  <input
                    type="text"
                    placeholder="Descripción del vídeo"
                    className="w-full p-1 border rounded"
                    value={video.description}
                    onChange={(e) => handleVideoChange(i, j, "description", e.target.value)}
                  />
                  <input
                    type="url"
                    placeholder="URL del vídeo"
                    className="w-full p-1 border rounded"
                    value={video.url}
                    onChange={(e) => handleVideoChange(i, j, "url", e.target.value)}
                    required
                  />
                  <button
                    type="button"
                    onClick={() => handleRemoveVideo(i, j)}
                    className="text-red-600 text-sm"
                  >
                    Eliminar vídeo
                  </button>
                </div>
              ))}
              <button
                type="button"
                onClick={() => handleAddVideo(i)}
                className="text-blue-600 text-sm"
              >
                + Añadir vídeo
              </button>
            </div>

            <button
              type="button"
              onClick={() => handleRemoveChapter(i)}
              className="text-red-600 text-sm"
            >
              Eliminar capítulo
            </button>
          </div>
        ))}

        <button
          type="button"
          onClick={handleAddChapter}
          className="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"
        >
          + Añadir capítulo
        </button>

        <button
          type="submit"
          className="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 block ml-auto"
        >
          {id ? "Actualizar curso" : "Crear curso"}
        </button>
      </form>
    </div>
  );
}

export default CourseFormPage;

