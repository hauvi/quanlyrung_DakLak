/* Bật tắt sidebar */
let Main = document.getElementById("sidebar");
let Table = document.getElementById("table");
let open = document.getElementById("open");
let opentab = document.getElementById("open-tab");
let closetab = document.getElementById("close-tab");

window.showNav = (flag) => {
    if (flag) {
        Main.classList.toggle("-translate-x-full");

        if (Table.classList.contains("w-4/5")) {
            Table.classList.remove("w-4/5");
            Table.classList.add("w-full");
        } else {
            Table.classList.remove("w-full");
            Table.classList.add("w-4/5");
        }
    }
};

window.showTab = (flag) => {
    if (flag) {
        Table.classList.toggle("-translate-y-full")
        opentab.classList.toggle("hidden");
        closetab.classList.toggle("hidden");
    }
};

/* Bật tắt accordion */
const accordionHeader = document.querySelectorAll(".accordion-header");
accordionHeader.forEach((header) => {
    header.addEventListener("click", function () {
        const accordionContent = header.parentElement.querySelector(".accordion-content");
        let accordionMaxHeight = accordionContent.style.maxHeight;

        // Condition handling
        if (accordionMaxHeight == "0px" || accordionMaxHeight.length == 0) {
            accordionContent.style.maxHeight = `${accordionContent.scrollHeight + 32}px`;
            header.parentElement.classList.add("border");
            header.parentElement.classList.add("border-black");
        } else {
            accordionContent.style.maxHeight = `0px`;
            header.parentElement.classList.remove("border");
            header.parentElement.classList.remove("border-black");
        }
    });
});