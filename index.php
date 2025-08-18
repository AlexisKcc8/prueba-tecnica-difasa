<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Prueba Técnica Difasa</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans text-gray-800 p-8">

  <section class="max-w-5xl mx-auto bg-white rounded-xl shadow-lg p-10">
    <h1 class="text-3xl font-extrabold text-blue-700 mb-10">Gestión de Rutas y Choferes</h1>

    <!-- Formulario Choferes -->
    <section class="mb-12">
      <h2 class="text-xl font-semibold text-gray-900 mb-4 border-b-2 border-blue-600 inline-block pb-1">Formulario de Choferes</h2>
      <form id="form_drivers" class="flex flex-col md:flex-row md:items-center md:gap-6">
        <input 
          type="text" 
          name="nameDriver" 
          id="driverName" 
          placeholder="Nombre del Chofer" 
          required 
          class="border border-gray-300 rounded-md p-3 flex-1 mb-4 md:mb-0 focus:ring-2 focus:ring-blue-500 transition"
        />
        <input 
          type="number" 
          name="phoneDriver" 
          id="driverPhone" 
          placeholder="Teléfono del Chofer" 
          required 
          class="border border-gray-300 rounded-md p-3 flex-1 mb-4 md:mb-0 focus:ring-2 focus:ring-blue-500 transition"
        />
        <button 
          type="submit" 
          class="bg-blue-600 text-white px-6 py-3 rounded-md font-semibold hover:bg-blue-700 transition"
        >
          Agregar Chofer
        </button>
      </form>
    </section>

    <!-- Formulario Rutas -->
    <section class="mb-12">
      <h2 class="text-xl font-semibold text-gray-900 mb-4 border-b-2 border-blue-600 inline-block pb-1">Formulario de Rutas</h2>
      <form id="form_routes" class="flex flex-col md:flex-row md:items-center md:gap-6">
        <input 
          type="text" 
          name="nameRoute" 
          id="nameRoute" 
          placeholder="Nombre de la ruta" 
          required 
          class="border border-gray-300 rounded-md p-3 flex-1 mb-4 md:mb-0 focus:ring-2 focus:ring-blue-500 transition"
        />
        <input 
          type="number" 
          name="id_chofer" 
          id="id_chofer" 
          placeholder="Ingrese el id del chofer" 
          required 
          class="border border-gray-300 rounded-md p-3 flex-1 mb-4 md:mb-0 focus:ring-2 focus:ring-blue-500 transition"
        />
        <button 
          type="submit" 
          class="bg-blue-600 text-white px-6 py-3 rounded-md font-semibold hover:bg-blue-700 transition"
        >
          Agregar Ruta
        </button>
      </form>
    </section>

    <!-- Formulario Puntos de Entrega -->
    <section>
      <h2 class="text-xl font-semibold text-gray-900 mb-4 border-b-2 border-blue-600 inline-block pb-1">Formulario de Puntos de entrega</h2>
      <form id="form_delivery_point" class="grid grid-cols-1 md:grid-cols-3 gap-6 items-end">
        <input 
          type="number" 
          name="id_ruta" 
          id="id_ruta" 
          placeholder="Ingrese el id de la ruta" 
          required 
          class="border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 transition"
        />
        <input 
          type="text" 
          name="dirrecion" 
          id="dirrecionRoute" 
          placeholder="Dirección de la ruta" 
          required 
          class="border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 transition"
        />
        <input 
          type="number" 
          name="orden" 
          id="ordenRoute" 
          placeholder="Ingrese el orden de la ruta" 
          required 
          class="border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 transition"
        />
        <div class="md:col-span-2 flex flex-col">
          <label for="ruta_entregada" class="mb-1 font-medium text-gray-700">Estado de Entrega:</label>
          <select 
            name="entregado" 
            id="ruta_entregada" 
            class="border border-gray-300 rounded-md p-3 focus:ring-2 focus:ring-blue-500 transition"
          >
            <option value="pendiente">Pendiente</option>
            <option value="entregado">Entregado</option>
          </select>
        </div>
        <button 
          type="submit" 
          class="bg-blue-600 text-white px-6 py-3 rounded-md font-semibold hover:bg-blue-700 transition"
        >
          Agregar Punto
        </button>
      </form>
    </section>
  </section>

  <!-- Listados -->
  <main class="max-w-5xl mx-auto mt-16 space-y-14">

    <!-- Choferes -->
    <section>
      <h2 class="text-2xl font-extrabold text-blue-700 mb-6">Choferes registrados</h2>
      <div id="choferes-container" class="grid grid-cols-1 md:grid-cols-3 gap-6"></div>

      <template id="chofer-template">
        <div class="chofer-card bg-white rounded-lg shadow-md p-6 flex flex-col justify-between hover:shadow-xl transition">
          <div>
            <p class="text-sm text-gray-500 mb-1"><strong>Id:</strong> <span class="idDrive"></span></p>
            <h3 class="driverName text-lg font-semibold text-gray-900 mb-2"></h3>
            <p class="text-gray-700"><strong>Teléfono:</strong> <span class="driverPhone"></span></p>
          </div>
          <div class="mt-4 flex gap-3 justify-end">
            <button class="btn-edit bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition">Editar</button>
            <button class="btn-delete bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition">Eliminar</button>
          </div>
        </div>
      </template>
    </section>

    <!-- Rutas -->
    <section>
      <h2 class="text-2xl font-extrabold text-blue-700 mb-6">Rutas registradas</h2>
      <div id="rutas-container" class="grid grid-cols-1 md:grid-cols-3 gap-6"></div>

      <template id="ruta-template">
        <div class="ruta-card bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
          <p class="text-sm text-gray-500 mb-1"><strong>Id_Ruta:</strong> <span class="idRoute"></span></p>
          <h3 class="rutaNombre text-lg font-semibold text-gray-900 mb-2"></h3>
          <p class="text-gray-700"><strong>Fecha:</strong> <span class="rutaFecha"></span></p>
          <p class="text-gray-700"><strong>Id del chofer:</strong> <span class="rutaIdChofer"></span></p>
          <div class="mt-4 flex gap-3">
            <button class="btn-edit-route bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition">Editar</button>
            <button class="btn-delete-route bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition">Eliminar</button>
          </div>
        </div>
      </template>
    </section>

    <!-- Puntos de Entrega -->
    <section>
      <h2 class="text-2xl font-extrabold text-blue-700 mb-6">Puntos de entrega registrados</h2>
      <div id="puntos-container" class="grid grid-cols-1 md:grid-cols-3 gap-6"></div>

      <template id="punto-template">
        <div class="punto-card bg-white rounded-lg shadow-md p-6 hover:shadow-xl transition">
          <p class="text-gray-700 mb-1"><strong>Id de la ruta:</strong> <span class="punto_id_ruta"></span></p>
          <p class="text-gray-700 mb-1"><strong>Dirección:</strong> <span class="puntoDireccion"></span></p>
          <p class="text-gray-700 mb-1"><strong>Orden solicitada:</strong> <span class="puntoOrden"></span></p>
          <p class="text-gray-700 mb-3"><strong>Estado de punto de entrega:</strong> <span class="puntoEstado"></span></p>
          <div class="flex gap-3">
            <button class="btn-edit-delivery bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition">Editar</button>
            <button class="btn-delete-delivery bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition">Eliminar</button>
          </div>
        </div>
      </template>
    </section>

  </main>

  <script type="module" src="./js/driverFetchs.js"></script>
  <script type="module" src="./js/routesFetch.js"></script>
  <script type="module" src="./js/deliveryFetch.js"></script>

</body>
</html>
