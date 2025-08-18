document.addEventListener("DOMContentLoaded", () => {
  renderDelivery();
  document.getElementById("form_delivery_point")?.addEventListener("submit", async (e) => {
        e.preventDefault();
        await addNewDelivery();
  });
});


async function renderDelivery() {
  const endpoint = "http://localhost/prueba-tecnica-difasa/api/delivery_points/getDelivery.php";
  const container = document.getElementById("puntos-container");
  const template = document.getElementById("punto-template");

  try {
    const response = await fetch(endpoint);

    if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

    const data = await response.json();

    if (!data.success || !Array.isArray(data.data)) {
      throw new Error("La respuesta no es válida.");
    }

    container.innerHTML = "";

    data.data.forEach(delivery => {
      const clone = template.content.cloneNode(true);
      clone.querySelector(".punto_id_ruta").textContent = delivery.id_ruta;
      clone.querySelector(".puntoDireccion").textContent = delivery.dirrecion;
      clone.querySelector(".puntoOrden").textContent = delivery.orden;
      clone.querySelector(".puntoEstado").textContent = delivery.entregado;

      // Botón eliminar
      const btnDelete = clone.querySelector(".btn-delete-delivery");
      btnDelete.addEventListener("click", () => deleteDelivery(delivery.id));

      // Botón editar
      const btnEdit = clone.querySelector(".btn-edit-delivery");
      btnEdit.addEventListener("click", () => editChofer(delivery));

      container.appendChild(clone);
    });

  } catch (error) {
    console.error("Error al obtener las rutas:", error);
    container.innerHTML = `<p style="color:red;">No se pudieron cargar las rutas.</p>`;
  }
}

export async function addNewDelivery() {
  const id_ruta = document.getElementById("id_ruta").value.trim();
  const dirrecion = document.getElementById("dirrecionRoute").value.trim();
  const orden = document.getElementById("ordenRoute").value.trim();
  const entregado = document.getElementById("ruta_entregada").value.trim();



  if (!id_ruta || !dirrecionRoute || !orden || !entregado) {
    alert("Todos los campos son obligatorios.");
    return;
  }

  try {
    const response = await fetch("http://localhost/prueba-tecnica-difasa/api/delivery_points/addDelivery.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json"
      },
      body: JSON.stringify({ id_ruta, dirrecion, orden, entregado })
    });

    const data = await response.json();

    if (data.Insertado) {
      alert("Ruta agregada correctamente.");
      renderDelivery(); 
      document.getElementById("id_ruta").value = "";
      document.getElementById("dirrecionRoute").value = "";
      document.getElementById("ordenRoute").value = "";
      document.getElementById("ruta_entregada").value = "";
    } else {
      alert("Error al agregar ruta: " + (data.message || "Error desconocido."));
    }

  } catch (error) {
    console.error("Error al agregar ruta:", error);
    alert("No se pudo agregar la ruta.");
  }
}


async function deleteDelivery(id) {
  const confirmed = confirm("¿Estás seguro de que deseas eliminar este punto de entrega?");
  if (!confirmed) return;

  try {
    const response = await fetch(`http://localhost/prueba-tecnica-difasa/api/delivery_points/deleteDelivery.php?id=${id}`, {
      method: "DELETE"
    });

    const data = await response.json();

    if (data.success) {
      alert("Ruta eliminada correctamente.");
      renderDelivery(); // Recargar lista
    } else {
      alert("Error al eliminar la ruta.");
    }
  } catch (error) {
    console.error("Error al eliminar ruta:", error);
    alert("No se pudo eliminar la ruta.");
  }
}
