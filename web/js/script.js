function showPhrase(){
    var person=prompt("¿Cuál es tu nombre?", "Escribe tu nombre");
    
    if (person != null){
        document.getElementById("bienvenida").innerHTML = "¡Bienvenido a la región de Alola, entrenador " +
        person + "! Gracias por Ingresar a mi página";
    }
}
