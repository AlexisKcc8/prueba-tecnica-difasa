document.addEventListener("DOMContentLoaded", () => {
  renderRoutes();
  document
    .getElementById("form_routes")
    ?.addEventListener("submit", async (e) => {
      e.preventDefault();
      await addNewRoute();
    });
});

async function renderRoutes() {
  const endpoint =
    "http://localhost/prueba-tecnica-difasa/api/routes_driver/getRoutes.php";
  const container = document.getElementById("rutas-container");
  const template = document.getElementById("ruta-template");
  const coloresFondo = [
    "bg-white",
    "bg-blue-50",
    "bg-green-50",
    "bg-yellow-50",
    "bg-pink-50",
  ];
  try {
    const response = await fetch(endpoint);

    if (!response.ok) throw new Error(`Error HTTP: ${response.status}`);

    const data = await response.json();

    if (!data.success || !Array.isArray(data.data)) {
      throw new Error("La respuesta no es válida.");
    }

    container.innerHTML = "";

    data.data.forEach((route, index) => {
      const clone = template.content.cloneNode(true);
      clone
        .querySelector(".ruta-card")
        .classList.add(coloresFondo[index % coloresFondo.length]);
      clone.querySelector(".idRoute").textContent = route.id;
      clone.querySelector(".rutaNombre").textContent = route.nombre;
      clone.querySelector(".rutaFecha").textContent = route.fecha;
      clone.querySelector(".rutaIdChofer").textContent = route.id_chofer;
      clone.querySelector(".rutaNameChofer").textContent = route.chofer_nombre;

      // Botón eliminar
      const btnDelete = clone.querySelector(".btn-delete-route");
      btnDelete.addEventListener("click", () => deleteRoute(route.id));

      // Botón editar
      const btnEdit = clone.querySelector(".btn-edit-route");
      btnEdit.addEventListener("click", () => updateRoutes(route));

      container.appendChild(clone);
    });
  } catch (error) {
    console.error("Error al obtener las rutas:", error);
    container.innerHTML = `<p style="color:red;">No se pudieron cargar las rutas.</p>`;
  }
}

export async function addNewRoute() {
  const nombre = document.getElementById("nameRoute").value.trim();
  const id_chofer = document.getElementById("chofer").value.trim();

  console.log(nombre, id_chofer);

  if (!nombre || !id_chofer) {
    alert("Todos los campos son obligatorios.");
    return;
  }

  try {
    const response = await fetch(
      "http://localhost/prueba-tecnica-difasa/api/routes_driver/postRoute.php",
      {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ nombre, id_chofer }),
      }
    );

    const data = await response.json();

    if (data.Insertado) {
      alert("Ruta agregada correctamente.");
      renderRoutes();
      document.getElementById("nameRoute").value = "";
      document.getElementById("chofer").value = "";
    } else {
      alert("Error al agregar ruta: " + (data.message || "Error desconocido."));
    }
  } catch (error) {
    console.error("Error al agregar ruta:", error);
    alert("No se pudo agregar la ruta.");
  }
}

async function deleteRoute(id) {
  const confirmed = confirm("¿Estás seguro de que deseas eliminar esta ruta?");
  if (!confirmed) return;

  try {
    const response = await fetch(
      `http://localhost/prueba-tecnica-difasa/api/routes_driver/deleteRoute.php?id=${id}`,
      {
        method: "DELETE",
      }
    );

    const data = await response.json();

    if (data.success) {
      alert("Ruta eliminada correctamente.");
      renderRoutes(); // Recargar lista
    } else {
      alert("Error al eliminar la ruta.");
    }
  } catch (error) {
    console.error("Error al eliminar ruta:", error);
    alert("No se pudo eliminar la ruta.");
  }
}

async function updateRoutes(chofer) {
  const nuevoNombre = prompt("Editar nombre del chofer:", chofer.nombre);
  const id_chofer = prompt("Editar id del chofer:", chofer.id_chofer);

  if (nuevoNombre === null || id_chofer === null) return;

  try {
    const response = await fetch(
      "http://localhost/prueba-tecnica-difasa/api/routes_driver/putRoute.php",
      {
        method: "PUT",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({
          id: chofer.id,
          nombre: nuevoNombre,
          id_chofer: id_chofer,
          fecha: new Date().toISOString(),
        }),
      }
    );

    const result = await response.json();

    if (result.Insertado) {
      alert("Ruta actualizada correctamente.");
      renderRoutes();
    } else {
      alert("Error al actualizar la ruta.");
    }
  } catch (error) {
    console.error("Error al actualizar ruta:", error);
    alert("No se pudo actualizar el chofer.");
  }
}
