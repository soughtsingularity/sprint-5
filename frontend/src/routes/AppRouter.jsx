import { Routes, Route, Navigate } from "react-router-dom";
import LoginPage from "../pages/LoginPage";
import RegisterPage from "../pages/RegisterPage";
import CourseListPage from "../pages/CourseListPage";
import CourseDetailPage from "../pages/CourseDetailPage";
import UserDashboardPage from "../pages/UserDashboardPage";
import AdminUserListPage from "../pages/AdminUserListPage";


function AppRouter() {
  return (
    <Routes>
      <Route path="/" element={<Navigate to="/courses" />} />
      <Route path="/courses" element={<CourseListPage />} />
      <Route path="/login" element={<LoginPage />} />
      <Route path="/register" element={<RegisterPage />} />
      <Route path="/dashboard" element={<UserDashboardPage />} />
      <Route path="/courses/:id" element={<CourseDetailPage />} />
      <Route path="/admin/users" element={<AdminUserListPage />} />
    </Routes>
  );
}

export default AppRouter;


