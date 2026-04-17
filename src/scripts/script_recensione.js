// modal film
const movies=document.querySelectorAll(".movie");
const modal=document.getElementById("modal");
if(movies){
movies.forEach(m=>{
m.onclick=()=>{
modal.style.display="flex";
modalTitle.innerText=m.dataset.title;
modalDesc.innerText=m.dataset.desc;
modalYear.innerText=m.dataset.year;
modalGenre.innerText=m.dataset.genre;
modalImg.src=m.dataset.img;
}
});
}

// stelle
const stars=document.querySelectorAll(".stars span");
const voto=document.getElementById("voto");
if(stars){
stars.forEach((s,i)=>{
s.onclick=()=>{
voto.value=s.dataset.value;
stars.forEach(x=>x.classList.remove("active"));
for(let j=0;j<=i;j++){stars[j].classList.add("active");}
}
});
}
