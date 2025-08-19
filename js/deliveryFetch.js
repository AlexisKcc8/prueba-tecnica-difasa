document.addEventListener("DOMContentLoaded", () => {
  renderDelivery();
  loadPointSelectOptions();
  document
    .getElementById("form_delivery_point")
    ?.addEventListener("submit", async (e) => {
      e.preventDefault();
      await addNewDelivery();
    });
});

async function loadPointSelectOptions(points) {
  const selectRutas = document.getElementById("id_ruta");
  // Limpiar opciones existentes excepto la opción por defecto
  selectRutas.innerHTML = '<option value="">-- Selecciona una ruta --</option>';
  try {
    const res = await fetch(
      "http://localhost/prueba-tecnica-difasa/api/routes_driver/getRoutes.php"
    );
    if (!res.ok) throw new Error("Error al cargar rutas");
    const points = await res.json();

    points.data.forEach((ruta) => {
      const option = document.createElement("option");
      option.value = ruta.id;
      option.textContent = ruta.nombre;
      selectRutas.appendChild(option);
    });
  } catch (error) {
    console.error(error);
  }
}

async function renderDelivery() {
  const endpoint =
    "http://localhost/prueba-tecnica-difasa/api/delivery_points/getDelivery.php";
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

    data.data.forEach((delivery) => {
      const clone = template.content.cloneNode(true);
      clone.querySelector(".punto_id_ruta").textContent = delivery.id_ruta;
      clone.querySelector(".puntoDireccion").textContent = delivery.direccion;
      clone.querySelector(".puntoOrden").textContent = delivery.orden;
      clone.querySelector(".puntoEstado").textContent = delivery.entregado;

      // Botón eliminar
      const btnDelete = clone.querySelector(".btn-delete-delivery");
      btnDelete.addEventListener("click", () => deleteDelivery(delivery.id));

      // Botón editar
      const btnEdit = clone.querySelector(".btn-edit-delivery");
      btnEdit.addEventListener("click", () => editPoint(delivery));

      container.appendChild(clone);
    });
  } catch (error) {
    console.error("Error al obtener las rutas:", error);
    container.innerHTML = `<p style="color:red;">No se pudieron cargar las rutas.</p>`;
  }
}

export async function addNewDelivery() {
  const id_ruta = document.getElementById("id_ruta").value.trim();
  const direccion = document.getElementById("dirrecionRoute").value.trim();
  const orden = document.getElementById("ordenRoute").value.trim();
  const entregado = document.getElementById("ruta_entregada").value.trim();

  if (!id_ruta || !dirrecionRoute || !orden || !entregado) {
    alert("Todos los campos son obligatorios.");
    return;
  }

  try {
    const response = await fetch(
      "http://localhost/prueba-tecnica-difasa/api/delivery_points/postDelivery.php",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ id_ruta, direccion, orden, entregado }),
      }
    );

    const data = await response.json();
    console.log("Respuesta del servidor:", data);

    if (data.Insertado) {
      alert("Punto de entrega agregada correctamente.");
      renderDelivery();
      document.getElementById("id_ruta").value = "";
      document.getElementById("dirrecionRoute").value = "";
      document.getElementById("ordenRoute").value = "";
      document.getElementById("ruta_entregada").value = "";
    } else {
      alert("Error al agregar ruta: " + (data.message || "Error desconocido."));
    }
  } catch (error) {
    console.error("Error al agregar Punto de entrega:", error);
    alert("No se pudo agregar el Punto de entrega.");
  }
}

async function editPoint(delivery) {
  const nuevoIdRuta = prompt("Editar id ruta del delivery:", delivery.id_ruta);
  const nuevoDireccion = prompt("Editar direccion:", delivery.direccion);
  const orden = prompt("Editar direccion:", delivery.orden);
  const entregado = prompt("Editar entrega:", delivery.entregado);

  if (
    nuevoIdRuta === null ||
    nuevoDireccion === null ||
    orden === null ||
    entregado === null
  )
    return; // Cancelado

  try {
    const response = await fetch(
      "http://localhost/prueba-tecnica-difasa/api/delivery_points/putDelivery.php",
      {
        method: "PUT", // o "PUT" según tu backend
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          id: delivery.id,
          id_ruta: nuevoIdRuta,
          direccion: nuevoDireccion,
          orden: orden,
          entregado: entregado,
        }),
      }
    );

    const result = await response.json();
    console.log(result);

    if (result.Insertado) {
      alert("delivery actualizado correctamente.");
      fetchAndRenderdeliveryes();
    } else {
      alert("Error al actualizar el delivery.");
    }
  } catch (error) {
    console.error("Error al actualizar delivery:", error);
    alert("No se pudo actualizar el delivery.");
  }
}

async function deleteDelivery(id) {
  const confirmed = confirm(
    "¿Estás seguro de que deseas eliminar este punto de entrega?"
  );
  if (!confirmed) return;

  try {
    const response = await fetch(
      `http://localhost/prueba-tecnica-difasa/api/delivery_points/deleteDelivery.php?id=${id}`,
      {
        method: "DELETE",
      }
    );

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
