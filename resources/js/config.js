import axios from "axios";

// export const api_url = "http://localhost/";
export const api_url = "http://127.0.0.1:8000/api/";

export const cusaxios = axios.create({
    baseURL: api_url,
    headers: {
        'Content-Type': 'multipart/form-data',
    },
});