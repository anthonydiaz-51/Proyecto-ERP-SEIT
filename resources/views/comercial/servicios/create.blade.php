<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white">Nuevo servicio</h2>
    </x-slot>

    <div
        x-data="{
            categoriaNombre: '',
            servicioNombre: @js(old('servicio', '')),

            serviciosPorCategoria: {
                'Soporte técnico': [
                    'Diagnóstico de computadora',
                    'Mantenimiento preventivo',
                    'Mantenimiento correctivo',
                    'Limpieza interna y externa',
                    'Cambio de pasta térmica',
                    'Cambio de ventiladores',
                    'Cambio de disco HDD/SSD',
                    'Ampliación de memoria RAM',
                    'Instalación/cambio de fuente de poder',
                    'Reparación de problemas de encendido',
                    'Reparación de problemas de sobrecalentamiento',
                    'Optimización de rendimiento',
                    'Configuración de BIOS/UEFI',
                    'Recuperación de información',
                    'Respaldo de información',
                    'Clonación de discos',
                    'Migración HDD → SSD',
                    'Instalación de Windows',
                    'Formateo y reinstalación',
                    'Configuración inicial de Windows',
                    'Instalación de controladores',
                    'Actualización de Windows',
                    'Instalación de programas',
                    'Configuración de Microsoft Office',
                    'Instalación de antivirus',
                    'Eliminación de malware',
                    'Limpieza y optimización del sistema',
                    'Corrección de errores de software',
                    'Configuración de impresoras',
                    'Configuración de correo electrónico',
                    'Recuperación de cuentas/perfiles cuando sea técnicamente posible',
                    'Configuración de equipos nuevos',
                    'Migración de información de un equipo a otro',
                    'Otro'
                ],

                'Redes / Cableado estructurado': [
                    'Configuración de redes LAN',
                    'Configuración de Wi-Fi',
                    'Configuración de routers',
                    'Configuración de switches',
                    'Compartición de archivos e impresoras',
                    'Configuración de grupos de trabajo',
                    'Instalación de cableado de red',
                    'Ponchado de cables UTP',
                    'Certificación/prueba básica de cableado',
                    'Diagnóstico de problemas de red',
                    'Configuración de IP',
                    'Configuración de acceso remoto',
                    'Configuración de VPN',
                    'Configuración de NAS/servidores',
                    'Otro'
                ],

                'Sistemas de seguridad': [
                    'Instalación de cámaras CCTV',
                    'Configuración de DVR/NVR',
                    'Configuración de cámaras IP',
                    'Cableado para CCTV',
                    'Configuración de acceso remoto',
                    'Instalación de discos para videograbación',
                    'Mantenimiento de cámaras',
                    'Diagnóstico de pérdida de señal',
                    'Configuración de monitoreo en celular',
                    'Instalación de alarmas',
                    'Instalación de control de acceso',
                    'Otro'
                ],

                'Diseño web / Hosting / Dominios': [
                    'Diseño Web',
                    'Redes sociales',
                    'Configuración de dominios',
                    'Configuración de hosting',
                    'Creación/configuración de cuentas de correo',
                    'Configuración de Google Workspace',
                    'Configuración de Google Business Profile',
                    'Administración básica de sitios web',
                    'Actualización de páginas web',
                    'Certificados SSL',
                    'Configuración de respaldos',
                    'Soporte de plataformas empresariales',
                    'Otro'
                ],

                'Venta equipo': [
                    'Venta de computadoras de escritorio y laptops',
                    'Venta de impresoras y multifuncionales',
                    'Venta de componentes y refacciones para PC',
                    'Venta de periféricos y accesorios de cómputo',
                    'Venta de consumibles de impresión',
                    'Venta de equipos y accesorios de redes',
                    'Venta de camaras y sistemas de videovigilancia',
                    'Venta de almacenamiento y respaldos de información',
                    'Venta de equipo tecnológico para empresas, escuelas y hogares',
                    'Otro'
                ],
                'Educación': [
                    'Cursos de mantenimiento preventivo y correctivo de computadoras',
                    'Cursos de reparación y mantenimiento de teléfonos celulares',
                    'Capacitación en instalación y configuración de software',
                    'Cursos de redes informáticas y conectividad',
                    'Capacitación en instalación de cámaras de seguridad',
                    'Cursos de herramientas digitales y ofimática',
                    'Asesoría tecnológica para estudiantes y emprendedores',
                    'Talleres prácticos de electrónica y diagnóstico técnico',
                    'Capacitación tecnológica para empresas y grupos de trabajo',
                    'Otro'
                ],
                'Publicidad': [
                    'Diseño de logotipos e identidad corporativa',
                    'Diseño de publicidad digital e impresa',
                    'Diseño y elaboración de flyers, carteles y folletos',
                    'Diseño de tarjetas de presentación y papelería comercial',
                    'Creación de contenido para redes sociales',
                    'Administración y gestión de redes sociales',
                    'Diseño y desarrollo de páginas web comerciales',
                    'Creación de catálogos digitales de productos y servicios',
                    'Publicidad y promoción de negocios en Internet',
                    'Configuración y optimización de perfiles de Google Business Profile',
                    'Gestión de campañas publicitarias en Google Ads',
                    'Diseño de banners, lonas y material promocional',
                    'Otro'
                ]
            },

            get opcionesServicio() {
                return this.serviciosPorCategoria[this.categoriaNombre] || ['Otro'];
            },

            actualizarCategoria(select) {
                this.categoriaNombre =
                    select.selectedOptions[0]?.dataset.nombre || '';

                this.servicioNombre = '';
            },

            inicializarCategoria() {
                this.categoriaNombre =
                    this.$refs.categoria.selectedOptions[0]?.dataset.nombre || '';
            },

            limpiarFormulario() {
                this.$nextTick(() => {
                    this.categoriaNombre =
                        this.$refs.categoria.selectedOptions[0]?.dataset.nombre || '';

                    this.servicioNombre = '';
                });
            }
        }"
        x-init="inicializarCategoria()"
        class="max-w-3xl mx-auto py-6"
    >
        <div class="bg-white shadow rounded-lg p-6">
            <form
                method="POST"
                action="{{ route('comercial.servicios.store') }}"
                @reset="limpiarFormulario()"
            >
                @csrf

                <div class="mb-4">
                    <label
                        for="categoria_id"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Categoría
                    </label>

                    <select
                        id="categoria_id"
                        name="categoria_id"
                        x-ref="categoria"
                        @change="actualizarCategoria($event.target)"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300"
                    >
                        <option
                            value=""
                            data-nombre=""
                            {{ old('categoria_id') ? '' : 'selected' }}
                        >
                            -- Selecciona una categoría --
                        </option>

                        @foreach($categorias as $categoria)
                            <option
                                value="{{ $categoria->id }}"
                                data-nombre="{{ $categoria->nombre }}"
                                {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}
                            >
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>

                    @error('categoria_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label
                        for="servicio"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Servicio
                    </label>

                    <select
                        id="servicio"
                        name="servicio"
                        x-model="servicioNombre"
                        required
                        class="mt-1 block w-full rounded-md border-gray-300"
                    >
                        <option value="">-- Selecciona un servicio --</option>

                        <template x-for="opcion in opcionesServicio" :key="opcion">
                            <option :value="opcion" x-text="opcion"></option>
                        </template>
                    </select>

                    @error('servicio')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label
                        for="descripcion"
                        class="block text-sm font-medium text-gray-700"
                    >
                        Descripción
                    </label>

                    <textarea
                        id="descripcion"
                        name="descripcion"
                        rows="3"
                        placeholder="Si seleccionaste “Otro”, describe aquí el servicio."
                        class="mt-1 block w-full rounded-md border-gray-300"
                    >{{ old('descripcion') }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label
                            for="precio_base"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Precio base
                        </label>

                        <input
                            id="precio_base"
                            type="number"
                            step="0.01"
                            min="0"
                            name="precio_base"
                            value="{{ old('precio_base') }}"
                            required
                            class="mt-1 block w-full rounded-md border-gray-300"
                        >

                        @error('precio_base')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label
                            for="tipo_precio"
                            class="block text-sm font-medium text-gray-700"
                        >
                            Tipo de precio
                        </label>

                        <input
                            id="tipo_precio"
                            type="text"
                            name="tipo_precio"
                            value="{{ old('tipo_precio') }}"
                            placeholder="FIJO, POR_HORA, POR_EQUIPO..."
                            class="mt-1 block w-full rounded-md border-gray-300"
                        >
                    </div>
                </div>

                <div class="mb-6">
                    <label class="inline-flex items-center">
                        <input
                            type="checkbox"
                            name="promocion"
                            value="1"
                            {{ old('promocion') ? 'checked' : '' }}
                        >

                        <span class="ml-2 text-sm text-gray-700">
                            Marcar como promoción
                        </span>
                    </label>
                </div>

                <div class="flex justify-end gap-3">
                    <button
                        type="reset"
                        class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-md hover:bg-gray-100"
                    >
                        Limpiar
                    </button>

                    <a
                        href="{{ route('comercial.servicios.index') }}"
                        class="px-4 py-2 text-sm text-gray-600"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700"
                    >
                        Guardar servicio
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>