//script.js 
function toggleProfileInfo() {
    var profileInfo = document.getElementById("profile-info");
    profileInfo.style.display = profileInfo.style.display === "none" ? "block" : "none";
}

function togglePostForm() {
    var postForm = document.getElementById("postForm");
    postForm.style.display = postForm.style.display === "none" ? "block" : "none";
}
function editarPublicacion(id) {
    // Redirigir a una página de edición con el id de la publicación
    window.location.href = `editar_publicacion.php?id=${id}`;
}

function eliminarPublicacion(id) {
    if (confirm("¿Estás seguro de que deseas eliminar esta publicación?")) {
        window.location.href = `eliminar_publicacion.php?id=${id}`;
    }
}

function ocultarPublicacion(id) {
    // Opcional: oculta la publicación en la interfaz del usuario sin eliminarla de la base de datos
    document.getElementById(`publicacion-${id}`).style.display = 'none';
}

