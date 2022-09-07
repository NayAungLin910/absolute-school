import React from "react";
import { createRoot } from "react-dom/client";
import { HashRouter, Routes, Route } from "react-router-dom";
import Statistics from "./Statistics/Statistics";

const MainRouter = () => {
    return (
        <HashRouter>
            <Routes>
                <Route path="/" element={<Statistics />} />
            </Routes>
        </HashRouter>
    )
}

createRoot(document.getElementById("root")).render(<MainRouter />);