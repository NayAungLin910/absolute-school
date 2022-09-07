import React from "react";
import { createRoot } from "react-dom/client";
import { HashRouter, Routes, Route } from "react-router-dom";
import CreateUpload from "./Upload/CreateUpload";

const MainRouter = () => {
    return (
        <HashRouter>
            <Routes>
                <Route path="/" element={<CreateUpload />} />
            </Routes>
        </HashRouter>
    )
}

createRoot(document.getElementById("root")).render(<MainRouter />);