document.addEventListener('DOMContentLoaded', function () {
    const departamentos = {
       'Urabá': ['Apartadó', 'Arboletes', 'Carepa', 'Chigorodó', 'Mutatá', 'Murindó', 'Necoclí', 'San Juan de Urabá', 'San Pedro de Urabá', 'Turbo', 'Vigía del Fuerte'],

        
        // Añadir más departamentos y ciudades según sea necesario
    };

    const departamentoSelect = document.getElementById('departamento');
    const ciudadSelect = document.getElementById('ciudad');

    // Añadir opciones de departamentos al select
    for (const departamento in departamentos) {
        const option = document.createElement('option');
        option.value = departamento;
        option.textContent = departamento;
        departamentoSelect.appendChild(option);
    }

    // Manejar el cambio de departamento
    departamentoSelect.addEventListener('change', function () {
        const selectedDepartamento = departamentoSelect.value;
        const ciudades = departamentos[selectedDepartamento];

        // Limpiar el select de ciudades
        ciudadSelect.innerHTML = '<option value="" disabled selected>Ciudad</option>';

        // Añadir las nuevas opciones de ciudades
        ciudades.forEach(ciudad => {
            const option = document.createElement('option');
            option.value = ciudad;
            option.textContent = ciudad;
            ciudadSelect.appendChild(option);
        });

        // Habilitar el select de ciudades
        ciudadSelect.disabled = false;
    });

    // Inicialmente desactivar el select de ciudades
    ciudadSelect.disabled = true;
});