document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("filmModal");
    const modalImg = document.getElementById("modalImg");
    const modalTitle = document.getElementById("modalTitle");
    const modalDesc = document.getElementById("modalDesc");
    const modalYear = document.getElementById("modalYear");
    const modalGenre = document.getElementById("modalGenre");
    const closeBtn = document.querySelector(".modal .close");

    const cards = document.querySelectorAll(".film-card");
    console.log("CARDS TROVATE:", cards.length);

    cards.forEach(card => {
        card.addEventListener("click", () => {
            modalImg.src = card.dataset.img;
            modalTitle.textContent = card.dataset.title;
            modalDesc.textContent = card.dataset.desc;
            modalYear.textContent = card.dataset.year;
            modalGenre.textContent = card.dataset.genre;

            modal.style.display = "block";
        });
    });

    closeBtn.addEventListener("click", () => modal.style.display = "none");
    window.addEventListener("click", e => {
        if (e.target === modal) modal.style.display = "none";
    });
});
