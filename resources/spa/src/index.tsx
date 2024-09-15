import "./app.css";

import { createRoot } from "react-dom/client";

import { App } from "./ReactApp";

const root = document.getElementById("root");

if (root) {
    createRoot(root).render(<App />);
}
