import React from "react";

const Loader = () => {
    return (
        <div className="text-center">
            <div
                className="spinner-grow text-light"
                style={{ width: "5rem", height: "5rem" }}
                role="status"
            >
                <span className="sr-only">Loading...</span>
            </div>
        </div>
    );
};

export default Loader;
