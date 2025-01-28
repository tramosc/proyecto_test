document.addEventListener("DOMContentLoaded", () => {
    const bodegaSelect = document.getElementById("bodega");
    const sucursalSelect = document.getElementById("sucursal");
    const monedaSelect = document.getElementById("moneda");

    // Cargar bodegas
    fetch("obtener_datos.php?type=bodegas")
        .then(response => response.json())
        .then(data => {
            data.forEach(bodega => {
                bodegaSelect.innerHTML += `<option value="${bodega.id}">${bodega.nombre}</option>`;
            });
        });

    // Cargar monedas
    fetch("obtener_datos.php?type=monedas")
        .then(response => response.json())
        .then(data => {
            data.forEach(moneda => {
                monedaSelect.innerHTML += `<option value="${moneda.id}">${moneda.nombre}</option>`;
            });
        });

    // Cargar sucursales dinámicamente
    bodegaSelect.addEventListener("change", () => {
        sucursalSelect.innerHTML = '<option value="">Seleccione una sucursal</option>';
        fetch(`obtener_datos.php?type=sucursales&bodega_id=${bodegaSelect.value}`)
            .then(response => response.json())
            .then(data => {
                data.forEach(sucursal => {
                    sucursalSelect.innerHTML += `<option value="${sucursal.id}">${sucursal.nombre}</option>`;
                });
            });
    });

    // Validación y envío del formulario
    const form = document.getElementById("form-producto");
    form.addEventListener("submit", e => {
        e.preventDefault();

        // Validar código
        const codigo = document.getElementById("codigo").value;
        if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{5,15}$/.test(codigo)) {
            alert("El código del producto es inválido.");
            return;
        }

        // Validar materiales
        const materiales = document.querySelectorAll("input[name='material[]']:checked");
        if (materiales.length < 2) {
            alert("Debe seleccionar al menos dos materiales.");
            return;
        }

        // Enviar datos
        const formData = new FormData(form);
        fetch("guardar_producto.php", {
            method: "POST",
            body: formData,
        })
            .then(response => response.text())
            .then(result => alert(result))
            .catch(error => console.error("Error:", error));
    });
});
