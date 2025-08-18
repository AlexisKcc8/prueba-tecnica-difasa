document.addEventListener("DOMContentLoaded", () => {
  fetchAndRenderChoferes();
  document.getElementById("form_drivers")?.addEventListener("submit", async (e) => {
    e.preventDefault();
    await addChofer();
  });
  
});

async function fetchAndRenderChoferes() {
  const endpoint = "http://localhost/prueba-tecnica-difasa/api/driver/getDrivers.php";
  const container = document.getElementById("choferes-container");
  const template = document.getElementById("chofer-template");

  try {
    const response = await fetch(endpoint);

    if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

    const data = await response.json();

    if (!data.success || !Array.isArray(data.data)) {
      throw new Error("La respuesta no es válida.");
    }

    container.innerHTML = "";

    data.data.forEach(chofer => {
      const clone = template.content.cloneNode(true);
      clone.querySelector(".idDrive").textContent = chofer.id;
      clone.querySelector(".driverName").textContent = "Chofer: " + chofer.nombre;
      clone.querySelector(".driverPhone").textContent = chofer.telefono;

      // Botón eliminar
      const btnDelete = clone.querySelector(".btn-delete");
      btnDelete.addEventListener("click", () => deleteDriver(chofer.id));

      // Botón editar
      const btnEdit = clone.querySelector(".btn-edit");
      btnEdit.addEventListener("click", () => editChofer(chofer));

      container.appendChild(clone);
    });

  } catch (error) {
    console.error("Error al obtener los choferes:", error);
    container.innerHTML = `<p style="color:red;">No se pudieron cargar los choferes.</p>`;
  }
}


export async function addChofer() {
  const nombre = document.getElementById("driverName").value.trim();
  const telefono = document.getElementById("driverPhone").value.trim();

  if (!nombre || !telefono) {
    alert("Todos los campos son obligatorios.");
    return;
  }

  try {
    const response = await fetch("http://localhost/prueba-tecnica-difasa/api/driver/addDriver.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ nombre, telefono })
    });

    const data = await response.json();

    if (data.Insertado) {
      alert("Chofer agregado correctamente.");
      fetchAndRenderChoferes(); // recargar lista
      // Limpiar campos del formulario
      document.getElementById("driverName").value = "";
      document.getElementById("driverPhone").value = "";
    } else {
      alert("Error al agregar chofer: " + (data.message || "Error desconocido."));
    }

  } catch (error) {
    console.error("Error al agregar chofer:", error);
    alert("No se pudo agregar el chofer.");
  }
}

async function deleteDriver(id) {
  const confirmed = confirm("¿Estás seguro de que deseas eliminar este chofer?");
  if (!confirmed) return;

  try {
    const response = await fetch(`http://localhost/prueba-tecnica-difasa/api/driver/deleteDriver.php?id=${id}`, {
      method: "DELETE"
    });

    const data = await response.json();

    if (data.success) {
      alert("Chofer eliminado correctamente.");
      fetchAndRenderChoferes(); // Recargar lista
    } else {
      alert("Error al eliminar el chofer.");
    }
  } catch (error) {
    console.error("Error al eliminar chofer:", error);
    alert("No se pudo eliminar el chofer.");
  }
}


/**
 * Muestra un prompt para editar al chofer y lo actualiza
 */
async function editChofer(chofer) {
  const nuevoNombre = prompt("Editar nombre del chofer:", chofer.nombre);
  const nuevoTelefono = prompt("Editar teléfono del chofer:", chofer.telefono);

  if (nuevoNombre === null || nuevoTelefono === null) return; // Cancelado

  try {
    const response = await fetch("http://localhost/prueba-tecnica-difasa/api/driver/updateDriver.php", {
      method: "PUT", // o "PUT" según tu backend
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({
        id: chofer.id,
        nombre: nuevoNombre,
        telefono: nuevoTelefono
      })
    });

    const result = await response.json();

    if (result.Insertado) {
      alert("Chofer actualizado correctamente.");
      fetchAndRenderChoferes();
    } else {
      alert("Error al actualizar el chofer.");
    }

  } catch (error) {
    console.error("Error al actualizar chofer:", error);
    alert("No se pudo actualizar el chofer.");
  }
}
