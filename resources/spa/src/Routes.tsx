import { createBrowserRouter, RouterProvider } from "react-router-dom";

import { Home } from "./pages/Home";
import { Login } from "./pages/Login";
import { Signup } from "./pages/Signup";

const router = createBrowserRouter([
    {
        path: "/app/",
        element: <Home />,
    },
    {
        path: "/app/login",
        element: <Login />,
    },
    {
        path: "/app/signup",
        element: <Signup />,
    },
]);

export function Routes() {
    return <RouterProvider router={router} />;
}
