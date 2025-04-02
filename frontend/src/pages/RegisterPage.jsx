import { useForm } from "react-hook-form";
import axios from "axios";
import { toast } from "react-toastify";
import { useNavigate } from "react-router-dom";
import { useAuth } from "../contexts/AuthContext";

function RegisterPage() {
  const { register, handleSubmit } = useForm();
  const { login } = useAuth();
  const navigate = useNavigate();

  const onSubmit = async (data) => {
    try {
      const res = await axios.post("http://localhost:8000/api/register", data);
      login(res.data.token, res.data.user);;
      toast.success("Registro exitoso");
      navigate("/courses");
    } catch (err) {
      if (err.response?.status === 422) {
        const errors = err.response.data.errors;
        Object.values(errors).forEach((msgs) =>
          msgs.forEach((msg) => toast.error(msg))
        );
      } else {
        toast.error("Error al registrarse");
      }
    }
  };

  return (
    <div className="max-w-md mx-auto mt-10">
      <h1 className="text-2xl font-bold mb-4 text-center">Crear cuenta</h1>
      <form onSubmit={handleSubmit(onSubmit)} className="space-y-4">
        <input {...register("username")} placeholder="Nombre de usuario" className="w-full border p-2 rounded" />
        <input {...register("email")} type="email" placeholder="Correo electrónico" className="w-full border p-2 rounded" />
        <input {...register("password")} type="password" placeholder="Contraseña" className="w-full border p-2 rounded" />
        <input {...register("password_confirmation")} type="password" placeholder="Confirmar contraseña" className="w-full border p-2 rounded" />
        <button type="submit" className="w-full bg-blue-600 text-white py-2 rounded">Registrarse</button>
      </form>
    </div>
  );
}

export default RegisterPage;
