## Descripción

La idea d’aquest projecte és que et recolzis en un model IA per desenvolupar part d’un projecte directament relacionat amb la nostra feina, però que, malauradament, per les limitacions temporals d’aquesta, la nostra especialitat no podem dur a terme…


L'entrega inclou una presentació sobre la IA seleccionada, interaccions amb la IA, anàlisi del codi, la connexió frontend-backend i reflexions sobre l'aprenentatge.


Lliurament:

Has de realitzar una presentació on exposis els següents punts:

Descripció del model IA seleccionat i el motiu de la seva elecció: Explica quina IA vas seleccionar i per què vas considerar que era l'opció més adequada per al projecte.

Registre de les interaccions amb la IA: Mostra un registre de les interaccions que consideris més significatives amb la IA, incloent-hi les preguntes realitzades i les respostes rebudes. Podràs proporcionar exemples concrets de com la IA t'ha ajudat durant el procés de desenvolupament.

Anàlisi del codi generat per la IA: Fes una anàlisi del codi generat per la IA, destacant les seves característiques principals i qualsevol ajust o modificació que hagis realitzat per adaptar-lo als requisits del projecte.

Descripció del procés de connexió entre el frontend i el backend: Explica com has aconseguit connectar el frontend generat per la IA amb el backend implementat en PHP/Laravel, detallant els reptes enfrontats durant aquest procés i les solucions implementades per superar-los.

Reflexió sobre el procés d'aprenentatge: Comparteix les teves reflexions personals sobre el procés d'aprenentatge, incloent-hi els aspectes més interessants o desafiants trobats durant el desenvolupament del projecte. Podràs destacar quines habilitats o coneixements vas adquirir gràcies a aquesta experiència.
Codi al repositori de GitHub: El codi desenvolupat haurà d'estar disponible al teu repositori de GitHub, facilitant així l'accés i la revisió del mateix per part dels interessats.

La presentació ha de ser clara, organitzada i amb contingut visual rellevant per donar suport a l'exposició de cada punt. Això et permetrà compartir la teva experiència i aprenentatges amb els teus companys i companyes, fomentant així l'intercanvi de coneixements i la retroalimentació constructiva.


Tota la informació, incloent-hi la presentació i cadascun dels punts anteriors, haurà d'estar documentada de manera clara i organitzada al README del teu repositori de GitHub.


#### ✔️  Nivell 1
Desenvolupa un client frontend per consumir l'API que vas desenvolupar a l'entrega anterior de l'Sprint 5.

Recomanem React, ja que al projecte de la ITAcademy els/les vostres companys/es ho faran servir. En cas que ja dominis React, et recomanem investigar sobre algun altre framework/llibreria frontend que no coneguis.

Recorda que, tal com vas fer al Developers Team, és interessant tenir clar com volem que es presenti l'aplicació a nivell gràfic abans de començar a crear el codi frontend.

#### ✔️  Nivell 2

Tanquem el cercle!

Esbrina com fer que el teu frontend treballi directament amb l’API que vas desenvolupar en l’entrega anterior.

Entendre com es presentarà la informació a nivell gràfic pot canviar la nostra manera de veure com hem de proporcionar la informació des del backend.

#### Nivell 3
Imagina que treballes en un mateix projecte amb companys/es que tenen diferents versions de PHP, o de Laravel, o de React, o de les llibreries de tercers...Al mesclar el codi font pot donar força problemes(no cal que expliquem perquè).

Existeix alguna eina per a evitar això? Docker!

Busca com dockeritzar la teva aplicació del Nivell 1 o la teva API de l'entrega anterior. O ambdues!

### 🔑 Requisitos 

- PHP 7.4+ 
- Laravel Framework 11.43.1
- Base de datos de preferencia
- Composer (Para gestionar dependencias de PHP instaladas en el proyecto). 

☕ Instalación

Clona este repositorio en tu máquina local. git clone https://github.com/soughtsingularity/sprint-5.git

- Accede a la carpeta del proyecto. cd nombre_del_repositorio

- Instala dependencias de composer: composer install

- Crea el archivo .env a partir de example.env cp .example.env .env 

IMPORTANTE: eN ALGUNOS ENTORNOS ES NECESARIO CAMBIAR LA VARIABLE DE ENTORNO APP_MAINTENANCE_DRIVER a file

⏩ Ejecución

- Accede a la carpeta frontend y ejecuta el comando ```npm run dev``` para levantar el sercidor de React
- Accede a la carpeta sprint-5, que es donde se guarda el backend y ejecuta ```php artisan serve```

Así tendrás los servidores incronizados y lo único que tienes que hacer para que tu front se conecte con la api del backend y insertar la ruta al endpoint concreto para cada funcionalidad

Por ejemplo:
Endpoint de login: api/login

Ruta del endpoint para registrarse para ser llamada desde el front (igual que con POstman):

```http://127.0.0.1:8000/api/login```

Así de simple es conectar un front con una api para que consuma ssus recursos en un entorno local. Dos servidores levantados y uno de ellos (el front) llamando a lo endpoint que la api nos provee


CHATGPT COMO HERRAMIENTA PARA CREAR EL PROYECTO:

A continuación adjuntaré una serie de observaciones, justificaciones y ejemplos de código que explican por qué he trabajado con ChatGPT:


# ¿Por qué ChatGPT?

### Es la AI con la que más a gusto me siento trabajando

Llevo trabajando con ChatGPT más de un año y podría decirse que he aprewndido a interactuar con él, lo cual me da una ventaja significativa respecto al uso de cualquier otra AI generativa. Sé que dicen que no es la mejor AI para programacion, que Claude es mejor, y esto puede que sea cierto cuando hablamos de programación avanzada como desarrollo de videojuegos en UnrealEngine o uso de librerías de programación para ciencia de Python. Pero, sinceramente, para el nivel para que se necesita en el bootcamp, ChatGPT me parece la herramienta más útil.

### Es una AI Generativa muy "didáctica" si se le pide

En el proceso de desarrollo-aprendizaje en el que nos encontramos en el bootcamp, la adaptabilidad de CHatGPT para mostrar procesos o errores de una manera clara, concisa y didáctica - si se le pide - hace de ChatGPT una herramienta poderosa para estudiantes que no solo necesitan que algo funcione, sino tamboién saber por qué funciona como funciona


### Su manejo del contexto de la conversación es muy robusto, pudiendo mantener conversaciones sin perder el hilo, incluso cuando algunos de los prompts son extensos (Líneas de código de toda una funcionalidad o varias)

Me he encontrado con chats de días de duración en los que chatGPT - a veces teniendo que pedírselo - mantenía conciencia del contexto de la conversación del día uno en el día 7, decenas de prompts y respuestas larguísimas después. Y esto es algo poderoso.

### Me parece la AI más fiable del mercado si se sabe como utilizarla, y cuando se sabe que modelo (4o, 4.5, o1, o3mini) es más recomendable utilizar

La eficacia de una AI está en cómo se usa, saber qué preguntar, cómo hacerlo, que datos aportar, que modelo usar, etcétera, se convierten en armas poderosas cuando te enfrentas a entornos desconocidos. Pues emepezar preguntando como funciona en su base un framework, por ejemplo, para acabar - en el mismo chat - teniendo una descripción detallada de como deberías usar ese framework para tu proyecto en concreto

### Funciones como la búsqueda en internet, en ocasiones ofrecen respuestas que van  más allá de lo actualizado que esté el modelo que se esté usando, aunque a veces comete errores (aluciona) cuando un conocimiento se le escapa o una implementación es demasiado nueva

No voy a engañarme, ChatGPT está programado para estar obligado a responder, esto se debe a que la información la tiene, pero a lo mejor no aparece por un prompt incompleto o pobre. Pero el hecho de que esté obligado a responder implica que en ocasiones alucina, y esto sucede sobretodo con versiones de software nuevas con las que no ha podido entrenarse.

Esto l osoluciona la función de búsqueda de información en internet, que la mayoría de las veces es de ayuda, pero en este punto digamos que debes tener bastante más claro el tema del que estáis hablando.

Pocas veces recomienda visitar la documentacion oficial, por ejemplo.

### PROYECTOS

El punto más fuerte de ChatGPT para mí es como gestiona los proyectos, pudiendo alamacenar hasta 15 archivos sin que el rezonamiento se vuelva más podre o alucine más, y pudiendo insertar instrucciones para el proyecto que Chat va a tener en cuenta en cualquier chat. Todavía no tiene contexto entre chats del mismo proyecto, es el único punto débil en este sentido


A continuación mostraré una serie de conversaciones que he tenido con Chat para preparar el proyecto y reconocer el terreno

## PROMPT: 

``
Chat GPT

Now it's time to create a frontend with REACT that can consume the information provided by the API endpoints. Don't solve anything yet, just give me an overview of how a decoupled frontend works that connects to a RET API (the one I've already developed) in a local environment.

🚀 Frontend with React (Decoupled Architecture)
🧠 Overview

This project follows a decoupled architecture, where the frontend is built with React and the backend is built with Laravel (REST API). Both parts run independently on different ports and communicate exclusively via HTTP requests.

🧱 Local Architecture

📦 Backend (Laravel API)
- Runs at: http://localhost:8000/api
- Handles: Authentication (Passport), roles and permissions (Spatie), and business logic

📦 Frontend (React)
- Runs at: http://localhost:3000
- Fetches data from Laravel API via axios/fetch

🔁 Development Workflow

1️⃣	Run Laravel backend with php artisan serve
2️⃣	Start React frontend with npm start
3️⃣	Choose an endpoint to work with (GET /api/courses, POST /api/login, etc.)
4️⃣	Test the endpoint in Postman first
5️⃣	Create the corresponding view or logic in React
6️⃣	Connect the frontend to the backend using axios or fetch
7️⃣	If authentication is required, include Authorization: Bearer TOKEN in headers
📡 Example: Displaying a List of Users
Endpoint (Laravel)
GET http://localhost:8000/api/users
Response (JSON)
[
  { "id": 1, "name": "Ramón", "email": "ramon@example.com" },
  { "id": 2, "name": "Lucía", "email": "lucia@example.com" }
]

import React, { useEffect, useState } from 'react';
import api from '../api/axios'; // axios instance with auth headers

const Users = () => {
  const [users, setUsers] = useState([]);

  useEffect(() => {
    api.get('/users')
      .then(response => setUsers(response.data))
      .catch(error => console.error('Error fetching users:', error));
  }, []);

  return (
    <div>
      <h1>User List</h1>
      <ul>
        {users.map(user => (
          <li key={user.id}>{user.name} — {user.email}</li>
        ))}
      </ul>
    </div>
  );
};

export default Users;

✍️ Example: Updating a Course via Form

1. Fetch and set current course data

const [course, setCourse] = useState(null);

useEffect(() => {
  api.get(`/courses/5`)
    .then(res => setCourse(res.data))
    .catch(err => console.error(err));
}, []);

2. Render and control the form

<input
  value={course?.title || ''}
  onChange={e => setCourse({ ...course, title: e.target.value })}
/>
3. Submit changes to backend
jsx
Copy
Edit
const handleSubmit = (e) => {
  e.preventDefault();

  api.put(`/courses/${course.id}`, course)
    .then(res => console.log('Course updated'))
    .catch(err => console.error(err));
};
🔐 Authentication and Security
Every protected request must include:


Authorization: Bearer YOUR_ACCESS_TOKEN
Laravel uses Passport to validate tokens and Spatie to enforce role-based permissions.

Invalid tokens return 401, and insufficient permissions return 403.

🌐 CORS Configuration
Allow requests from your frontend (localhost:3000) in config/cors.php:


'paths' => ['api/*'],
'allowed_origins' => ['http://localhost:3000'],

✅ Summary

✅ Your React app works independently from Laravel and communicates through the API.

✅ React receives JSON data from the API and stores it in state (useState).

✅ Components like tables, forms, and pages consume this data.

✅ All interactions (create, read, update, delete) are done via HTTP requests (GET, POST, PUT, DELETE).

✅ Authentication and authorization are handled with Laravel Passport and Spatie.

🧠 Bonus: Mental Model (Data Flow)
pgsql
Copy
Edit
📦 Laravel API →     JSON response
         ↓
📲 React receives it → stores in useState
         ↓
🎨 React renders data (tables, forms, etc.)
         ↓
✏️ User interacts with the UI
         ↓
📤 React sends modified data back to API
         ↓
✅ Laravel validates and responds
📁 Project Folder Example
bash
Copy
Edit
/frontend
  └── /src
      ├── /api
      │   └── axios.js
      ├── /pages
      │   ├── Users.jsx
      │   └── Courses.jsx
      └── App.jsx


## PROMPT:
I have a REST API in Laravel that I built from a front-end application. Now I need to build a front-end application with React to consume the API. How long do you think it will take to do this? The API consists of the following endpoints: 

ChatGPT:

You have already built a complete and functional REST API in Laravel (with Passport and Spatie). Now, the goal is to build a frontend application in React that consumes and interacts with that API, supporting user authentication, course management, and progress tracking.

🕒 Estimated Development Time
Given that you're a beginner in React and will rely on this AI assistant (me) to guide you step-by-step, the following realistic time estimates apply:

Module	Estimated Time
Project setup + routing + layout	0.5 – 1 day
Register & Login (with token)	1 – 1.5 days
View Courses (list + detail)	1 day
Enroll / Unenroll in course	1 day
Mark chapter as completed	0.5 – 1 day
View course progress	0.5 day
User account management (delete account)	0.5 day
Admin: View users	0.5 day
Admin: Create / Edit / Delete courses	1 – 1.5 days
Form validations + error handling	1 day
Auth persistence (localStorage + context)	0.5 day
Final UI styling + polish	1 day
Basic testing (optional)	0.5 – 1 day
⏳ Total Estimated Time
📦 8 – 12 working days (if you're focused and follow guidance).
With more experience, this can be reduced to 6 – 8 days.




## PROMPT:
Keep in mind that I'm a beginner, I've never made an app with React, and the exercise is based on relying on AI, that is, on you, to develop the frontend and connect it to my existing API. Determine which set of technologies is most appropriate based on your previous time estimate.

ChatoGPT

Recommended Stack (Simple & Beginner-Friendly)
Area	Tool / Library	Why?
Framework	React with Vite	Fast, modern and beginner-friendly
Routing	react-router-dom	SPA navigation between views
API Requests	axios	Cleaner and easier than fetch
State	Context API	Enough for auth and global state
Auth	localStorage + Context	To store the access token
Styling	Tailwind CSS	Quick, responsive, and efficient styling
Forms	react-hook-form	Light and flexible for managing inputs
Alerts	react-toastify	Easy toast notifications for success/error
📁 API Analysis → What Will Be Built in the Frontend
✅ 1. Authentication (Guest Routes)
Endpoint	Description
POST /api/register	User registration
POST /api/login	User login
Frontend Views and Components:

RegisterPage → form: name, username, email, password

LoginPage → form: email, password

AuthContext → to manage auth state & token

Navbar → shows login/logout button

✅ 2. Courses (Public, User, Admin)
Endpoint	Description
GET /api/courses	List all courses
GET /api/courses/:id	Get course by ID
POST /api/courses	Admin creates course
PUT /api/courses/:id	Admin edits course
DELETE /api/courses/:id	Admin deletes course
Frontend Views and Components:

CourseListPage → view all courses

CourseDetailPage → view course + videos + checkboxes

CourseFormPage → create/edit course (admin only)

CourseCard, VideoPlayer, ChapterCheckbox

✅ 3. Progress Tracking (User)
Endpoint	Description
POST /api/courses/:id/complete	Mark chapter as completed (chapterIndex)
Frontend Functionality:

ChapterCheckbox → to mark progress

ProgressBar (optional) → display user progress

✅ 4. Course Enrollment (User)
Endpoint	Description
POST /api/users/:id/courses/:course	Enroll in course
POST /api/users/:id/course/:id	Unenroll from course
Frontend Functionality:

EnrollButton → enroll/unenroll in course

UserCoursesPage → show enrolled courses

✅ 5. User Management (Admin)
Endpoint	Description
GET /api/users	List all users
GET /api/users/:id	Get user by ID
DELETE /api/users/:id	Delete own account
Frontend Views and Components:

AdminUserListPage → list all users (admin only)

DeleteAccountButton → allow users to delete their own account

🧭 React Routes Overview
Route	Page Component
/register	RegisterPage
/login	LoginPage
/courses	CourseListPage
/courses/:id	CourseDetailPage
/my-courses	UserCoursesPage
/admin/users	AdminUserListPage
/admin/courses/new	CourseFormPage (create)
/admin/courses/:id	CourseFormPage (edit)
🧩 Component List
Navbar

CourseCard

VideoPlayer

ChapterCheckbox

EnrollButton

ProgressBar

Toast (via react-toastify)

AuthContext

PrivateRoute (for protected views)

AdminRoute (admin-only access)

🧾 Forms Required
RegisterForm → name, username, email, password

LoginForm → email, password

CourseForm → title, description, content (chapters + videos)

ProgressForm → chapterIndex (for marking chapters)

🧠 Mental Model Summary
pgsql
Copy
Edit
📦 Laravel API
  ↓
📨 React fetches JSON
  ↓
🧠 useState/useEffect to store data
  ↓
🖼️ JSX renders UI (tables, forms, etc.)
  ↓
📝 User inputs → updates state
  ↓
📤 axios/fetch sends data back (POST/PUT/DELETE)
  ↓
✅ Laravel validates + responds

## PROMPT:
Okay, so step by step, we can develop the entire frontend in this chat?

ChatGPT:
Yes, 100% of the frontend will be built step by step in this chat. We will work in small, manageable phases, making sure you understand everything, and that each part connects correctly to your existing Laravel API.

This is a guided development process, tailored to your current backend structure and skill level.

✅ Development Plan: Phase-by-Phase Guide
Each stage corresponds to real REST API endpoints you've already built.

1️⃣ Initial Setup

⚙️ Create React project	With Vite (recommended)

📦 Install dependencies	axios, react-router-dom, tailwindcss, react-hook-form, react-toastify
🗂️ Setup folders	/pages, /components, /contexts, /api, /hooks
🔐 AuthContext	Manage login state and access token globally

2️⃣ Authentication (Register & Login):
📝 RegisterPage + RegisterForm	Fields: name, username, email, password
🔑 LoginPage + LoginForm	Fields: email, password
💾 Token storage	Save token in localStorage and React Context
🚨 Error handling	Show messages with react-toastify

3️⃣ Courses (Public Access): 
📚 CourseListPage	Calls GET /api/courses
📖 CourseDetailPage	Calls GET /api/courses/:id
▶️ VideoPlayer Component	Plays embedded YouTube video

4️⃣ Auth Logic + Route Protection
🔒 PrivateRoute	Protect routes that require login
🛡️ AdminRoute	Restrict admin-only views
🚪 Navbar	Dynamic Login/Logout button based on auth state

5️⃣ Enrollment & Progress Tracking
✅ EnrollButton	Enroll or unenroll in a course (POST to /api/users/{id}/courses/{course})
📝 ChapterCheckbox	Mark chapters as completed (POST to /api/courses/{id}/complete)
📊 ProgressBar (optional)	Show percentage of completed content

6️⃣ User Dashboard
📂 UserCoursesPage	List courses the user is enrolled in
🗑️ DeleteAccountButton	Allow users to delete their account (DELETE /api/users/:id)

7️⃣ Admin Panel
👥 AdminUserListPage	List all users (GET /api/users)
📄 CourseFormPage	Create/edit courses (POST, PUT, DELETE /api/courses)

🧠 Workflow Summary

We will work step by step through this development plan, always:

Verifying each API call in Postman first

Creating the visual structure (form, table, card, etc.)

Connecting to the API via axios

Handling authentication and validation

Displaying data dynamically using React state

Showing errors or success messages clearly

🧰 Technologies Used

React (Vite) → Core framework

React Router → SPA navigation

Axios → API requests

React Hook Form → Form handling

Tailwind CSS → Styling

React Toastify → Notifications

Context API → Global auth and role state

## PROMPT CORRECTING CHAT:

Lo que sigue es un prompt en el que tiuve que corregir a Chat para que no "alucinara

Before moving on to endpoints that require a token or authorization, I would like to connect and develop the functionalities for the public endpoints and, while we're at it, make my entry page the list of available courses. So, we should create the navbar, as you have proposed, and develop the functionality of the course list endpoint, which is what will be seen when entering the application.

ChatGPT:

We are now moving forward with this objective: displaying the course list as the public homepage, and preparing the base for future integration with protected endpoints.

🎯 Current Development Goals
Create a Navbar component that is always visible

1 Set up the root route / to redirect to /courses

2 Implement the CourseListPage view

3 Consume the endpoint GET /api/courses and display the list of courses

4 Prepare everything so clicking on a course navigates to /courses/:id

Let me know when you're ready to start with step 1.
Would you like me to generate the Navbar component and routing setup for you now?


## DEBUGGING WITH CHAT:

❌ Error: AuthContext is not defined or not exported
You're trying to import AuthContext directly, but it's not exported by name from the context file.

📌 Quick Context Recap
Inside AuthContext.jsx, you likely have:

js
Copy
Edit
const AuthContext = createContext();

export function AuthProvider({ children }) {
  // ...
}

export const useAuth = () => useContext(AuthContext);
This means:

✅ AuthProvider → exported by name

✅ useAuth → exported by name

❌ AuthContext → not exported

✅ Solutions
✅ Option 1 (Recommended): Use the useAuth hook
In LoginPage.jsx (or any component), change this:


import { AuthContext } from "../contexts/AuthContext"; // ❌

To this:

import { useAuth } from "../contexts/AuthContext"; // ✅
Then use it like this:

const { login } = useAuth();
🛠 Option 2: If you really need the raw context (rare)
If you actually need the AuthContext object directly, go back to AuthContext.jsx and add this line:

export const AuthContext = createContext();
⚠️ This is rarely necessary unless you're doing something advanced.

✅ Best practice: Always use useAuth() to access context values unless you have a specific reason not to.

💥 Error: React is not defined in main.jsx

main.jsx:10 Uncaught ReferenceError: React is not defined

✅ Quick Fix
Add this at the top of main.jsx:

import React from 'react';
✅ Corrected main.jsx Example

import React from 'react'; // 👈 Required
import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import 'react-toastify/dist/ReactToastify.css';
import { ToastContainer } from 'react-toastify';
import { AuthProvider } from './contexts/AuthContext';

import './index.css';
import App from './App.jsx';

createRoot(document.getElementById('root')).render(
  <React.StrictMode>
    <AuthProvider>
      <App />
      <ToastContainer />
    </AuthProvider>
  </React.StrictMode>
);
After saving, restart the dev server:

bash
Copy
Edit
npm run dev
🐛 Error: Cannot destructure property 'user' of useContext(...) as it is undefined
javascript
Copy
Edit
Uncaught TypeError: Cannot destructure property 'user' of 'useContext(...)' as it is undefined.
This happens when:

You're trying to use useContext(AuthContext) but the context value is undefined.

✅ Step-by-Step Fix

✅ 1. Export the custom hook properly in AuthContext.jsx
// src/contexts/AuthContext.jsx
export const useAuth = () => useContext(AuthContext);

✅ 2. In Navbar.jsx, use the hook instead of the raw context
import { useAuth } from "../contexts/AuthContext";

const { user, logout } = useAuth();
✅ 3. Make sure <Navbar /> is inside the <AuthProvider>
Open main.jsx:

<AuthProvider>
  <App /> {/* Navbar will be used somewhere inside App */}
</AuthProvider>
Then in App.jsx, make sure Navbar is rendered within that provider:

function App() {
  return (
    <>
      <Navbar />
      {/* Your routes here */}
    </>
  );
}

🧠 Why this happens

If you call useContext(AuthContext) before the context provider (<AuthProvider>) is applied, you'll get undefined. Then trying to destructure user from undefined throws this error.

## Prompt Perfect code example given by ChatGPT

Okay, let's get to the admin stuff. - View all users (user data and courses they're enrolled in) - Create a course (You know, course name and description, functionality to add or remove chapters, chapter name and definition, functionality to add or remove videos, video title and name) - Edit a course (Same as creating a course, but with the data for the course we're editing) - Delete a course (Button when viewing a course's details, like the enroll button for users)

Admin Functionalities – Step-by-Step Implementation
We will break down the admin features into clear, actionable steps so we can implement them one by one—without missing anything.

✅ 1. View All Users (with Courses & Progress)
📍 Route: /admin/users
🔧 Endpoint: GET /api/users
👨‍🏫 Accessible only if user.role === "admin"

React View to Create: AdminUserListPage.jsx

It will display:

Username

Email

Courses the user is enrolled in (including course title, progress, and medal)

✅ 2. Create a Course
📍 Route: /admin/courses/new
🔧 Endpoint: POST /api/courses
📄 Request Body (example JSON):

json
Copy
Edit
{
  "title": "Sample Course",
  "description": "Course description",
  "content": [
    {
      "title": "Chapter 1",
      "description": "Chapter description",
      "videos": [
        {
          "title": "Video 1",
          "description": "Video description",
          "url": "https://..."
        }
      ]
    }
  ]
}
React View to Create: CourseFormPage.jsx

🧩 This will use a dynamic form built with useState to add chapters and videos.

✅ 3. Edit a Course
📍 Route: /admin/courses/:id
🔧 Endpoint: PUT /api/courses/{id}
📄 Load the course first via GET /api/courses/{id} and reuse the same form as in creation mode.

✅ Use the same view: CourseFormPage.jsx
Detect "edit mode" based on the presence of an id in the route.

✅ 4. Delete a Course
📍 Action button shown in: /courses/:id
🔧 Endpoint: DELETE /api/courses/{id}
👁️‍🗨️ Button should only appear if user.role === "admin"

🚦 What do you want to start with?
🔘 View all users
🔘 Create a course
🔘 Edit a course
🔘 Delete a course

Pick one and we'll build it right now.

Prompt: View All Users
We’ll now build the view at /admin/users where an admin can see all registered users along with the courses they are enrolled in and their progress.

✅ 1. Route & Protection
In your AppRouter.jsx (or wherever your routes are declared), add:

<Route path="/admin/users" element={<AdminUserListPage />} />
Later, we can secure this route using AdminRoute. For now, let’s focus on building the page.

✅ 2. Component: AdminUserListPage.jsx

Create the file:
src/pages/AdminUserListPage.jsx

Paste the following code:

import { useEffect, useState } from "react";
import axios from "axios";
import { useAuth } from "../contexts/AuthContext";

function AdminUserListPage() {
  const { token } = useAuth();
  const [users, setUsers] = useState([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    axios
      .get("http://localhost:8000/api/users", {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      })
      .then((res) => {
        console.log("Users:", res.data.data);
        setUsers(res.data.data);
      })
      .catch((err) => console.error("Error fetching users:", err))
      .finally(() => setLoading(false));
  }, [token]);

  if (loading) {
    return <p className="text-center mt-10">Loading users...</p>;
  }

  return (
    <div className="max-w-5xl mx-auto mt-10">
      <h1 className="text-2xl font-bold mb-6">Registered Users</h1>

      {users.map((user) => (
        <div key={user.id} className="border rounded p-4 mb-6 shadow">
          <h2 className="text-lg font-semibold mb-1">{user.username}</h2>
          <p className="text-sm text-gray-600">{user.email}</p>

          <h3 className="mt-4 text-md font-medium">Enrolled Courses:</h3>
          {user.courses?.length > 0 ? (
            <ul className="list-disc ml-6">
              {user.courses.map((course) => (
                <li key={course.id}>
                  <span className="font-semibold">{course.title}</span> –{" "}
                  Progress: {course.progress}% – Medal: {course.medal}
                </li>
              ))}
            </ul>
          ) : (
            <p className="text-sm text-gray-500">No enrolled courses.</p>
          )}
        </div>
      ))}
    </div>
  );
}

export default AdminUserListPage;
✅ 3. How to Test It
Log in with an admin user

Navigate to http://localhost:5173/admin/users

You should see a list of users with their email, enrolled courses, progress, and medals

