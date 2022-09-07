// show toast function with message and type
export const showToast = (message, type) => {
    if (type == "info") {
        Toastify({
            text: message,
            duration: 3000,
            destination: "", // can put link 
            newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "linear-gradient(to right, #9CB1E9, #5B82EA)",
            },
            onClick: function () { } // Callback after click
        }).showToast();
    }
    if (type == "success") {
        Toastify({
            text: message,
            duration: 3000,
            destination: "", // can put link 
            newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "linear-gradient(to right, #76CC68, #40CD29)",
            },
            onClick: function () { } // Callback after click
        }).showToast();
    }
    if (type == "error") {
        Toastify({
            text: message,
            duration: 3000,
            destination: "", // can put link 
            newWindow: true,
            close: true,
            gravity: "top", // `top` or `bottom`
            position: "right", // `left`, `center` or `right`
            stopOnFocus: true, // Prevents dismissing of toast on hover
            style: {
                background: "linear-gradient(to right, #F07E63, #F04D26)",
            },
            onClick: function () { } // Callback after click
        }).showToast();
    }
}
