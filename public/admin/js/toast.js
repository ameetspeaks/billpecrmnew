class Toast {
    constructor() {
        this.toast = document.getElementById("toast");
        this.icon = this.toast.querySelector("#icon");
        this.msg = this.toast.querySelector("#message_box");
    }

    success(message, time = 2500) {
        this.icon.innerHTML = '<i class="bx bxs-check-circle bx-tada" ></i>';

        this.toast.classList.add("success");

        this.msg.querySelector(".heading").innerHTML = "Success";
        this.msg.querySelector(".message").innerHTML = message;

        this.toast.classList.add("show");

        this.hide(time);
    }
    info(message, time = 2500) {
        this.icon.innerHTML = '<i class="bx bxs-error-circle bx-tada" ></i>';

        this.toast.classList.add("info");

        this.msg.querySelector(".heading").innerHTML = "Info";
        this.msg.querySelector(".message").innerHTML = message;

        this.toast.classList.add("show");

        this.hide(time);
    }
    warning(message, time = 2500) {
        this.icon.innerHTML = '<i class="bx bxs-error-circle bx-tada" ></i>';

        this.toast.classList.add("warning");

        this.msg.querySelector(".heading").innerHTML = "Warning";
        this.msg.querySelector(".message").innerHTML = message;

        this.toast.classList.add("show");

        this.hide(time);
    }
    error(message, time = 2500) {
        this.icon.innerHTML = '<i class="bx bxs-x-circle bx-tada" ></i>';

        this.toast.classList.add("error");

        this.msg.querySelector(".heading").innerHTML = "Error";
        this.msg.querySelector(".message").innerHTML = message;

        this.toast.classList.add("show");

        this.hide(time);
    }

    hide(time) {
        setTimeout(function () {
            this.toast.classList.remove("show");
            setTimeout(() => (this.toast.className = ""), 500);
        }, time);
    }
}

const toast = new Toast();
