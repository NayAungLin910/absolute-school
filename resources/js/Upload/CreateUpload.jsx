import { isArray } from "lodash";
import React, { Fragment, useEffect, useState } from "react";
import { useDropzone } from "react-dropzone";
import { showToast } from "../app";
import { cusaxios } from "../config";
import Loader from "../Loader/Loader";

const CreateUpload = () => {
    const [form, setForm] = useState(window.form);
    // const [test, setTest] = useState();
    const [error, setError] = useState();
    const [load, setLoad] = useState(false);
    const [subFile, setSubFile] = useState();

    // react-dropzone
    const onDrop = (files) => {
        setSubFile([...files]);
    };
    const { acceptedFiles, getRootProps, getInputProps } = useDropzone({
        onDrop: onDrop,
        multiple: true,
    });

    const files = subFile?.map((file) => {
        return (
            <li key={file.path} className="text-white">
                {file.type.includes("application") && (
                    <i
                        className="fa-solid fa-file"
                        style={{ marginRight: "10px" }}
                    ></i>
                )}
                {file.type.includes("text") && (
                    <i
                        className="fa-solid fa-file-lines"
                        style={{ marginRight: "10px" }}
                    ></i>
                )}
                {file.type.includes("image") && (
                    <i
                        className="fa-solid fa-image"
                        style={{ marginRight: "10px" }}
                    ></i>
                )}
                {file.type.includes("video") && (
                    <i
                        className="fa-solid fa-video"
                        style={{ marginRight: "10px" }}
                    ></i>
                )}
                {!file.type.includes("application") &&
                    !file.type.includes("image") &&
                    !file.type.includes("text") &&
                    !file.type.includes("video") && (
                        <i
                            className="fa-solid fa-file"
                            style={{ marginRight: "10px" }}
                        ></i>
                    )}
                {file.path} - {file.size} bytes
            </li>
        );
    });

    // submit files
    const submit = () => {
        setLoad(true);
        let data = new FormData();
        subFile?.map((file) => {
            data.append("uploads[]", file);
        });
        data.append("user_id", window.auth.id);
        data.append("form", JSON.stringify(form));
        cusaxios.post("/student/submit-files", data).then(({ data }) => {
            setLoad(false);
            if (data.success) {
                setSubFile([]);
                showToast(data.data, "success");
            } else {
                setError(data.data);
            }
        });
    };

    return (
        <Fragment>
            <div className="row">
                <div className="col-sm-12">
                    {load && (
                        <center>
                            <Loader />
                        </center>
                    )}
                    {!load && (
                        <Fragment>
                            <h4 className="text-white text-center">
                                {form.name}
                            </h4>
                            <h5 className="text-white mb-3 text-center">
                                <i
                                    className="fa-solid fa-file-arrow-up"
                                    style={{ marginRight: "8px" }}
                                ></i>
                                Submit Files
                            </h5>
                            <br />
                            <div
                                className="text-white p-3"
                                style={{
                                    borderStyle: "solid",
                                    borderColor: "#7386D5",
                                }}
                            >
                                <div
                                    {...getRootProps({ className: "dropzone" })}
                                >
                                    <input {...getInputProps()} multiple />
                                    <h1
                                        className="text-center"
                                        style={{ opacity: "0.8" }}
                                    >
                                        <i className="fa-solid fa-file-arrow-up"></i>
                                    </h1>
                                    <p
                                        className="text-center"
                                        style={{ opacity: "0.7" }}
                                    >
                                        <i>
                                            Drag and drop some files here, or
                                            click to select files
                                        </i>
                                    </p>
                                </div>
                            </div>
                            {subFile && isArray(subFile) && subFile.length > 0 && (
                                <aside className="mt-3">
                                    <div
                                        className="container"
                                        style={{ maxWidth: "80vw" }}
                                    >
                                        <ul>{files}</ul>
                                    </div>
                                </aside>
                            )}
                            {error &&
                                Object.keys(error).map((e, index) => (
                                    <p
                                        key={index}
                                        className="text-danger"
                                        style={{ backgroundColor: "white" }}
                                    >
                                        {error[e][0]}
                                    </p>
                                ))}
                            <button
                                className="btn btn-primary mt-3"
                                onClick={submit}
                            >
                                Submit
                            </button>
                        </Fragment>
                    )}
                </div>
            </div>
        </Fragment>
    );
};

export default CreateUpload;
