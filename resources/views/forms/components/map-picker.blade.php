@php
    use Illuminate\Support\Str;

    $statePath = $getStatePath();
    $basePath = Str::beforeLast($statePath, '.');
    $latPath = $basePath . '.' . $getLatitudeField();
    $lngPath = $basePath . '.' . $getLongitudeField();
    $radiusPath = $basePath . '.' . $getRadiusField();
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :state-path="$statePath"
>
    <div
        x-data="mapPicker(@js($latPath), @js($lngPath), @js($radiusPath))"
        x-init="init()"
        wire:ignore
    >
        <div x-ref="map" style="height: 350px; border-radius: 0.5rem;"></div>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
            Klik di peta atau geser marker untuk memilih lokasi.
        </p>
    </div>
</x-dynamic-component>

@once
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            function mapPicker(latPath, lngPath, radiusPath) {
                return {
                    map: null,
                    marker: null,
                    circle: null,

                    init() {
                        let lat = parseFloat(this.$wire.get(latPath)) || -6.200000;
                        let lng = parseFloat(this.$wire.get(lngPath)) || 106.816666;
                        let radius = parseFloat(this.$wire.get(radiusPath)) || 100;

                        this.map = L.map(this.$refs.map).setView([lat, lng], 17);

                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; OpenStreetMap contributors',
                            maxZoom: 19,
                        }).addTo(this.map);

                        this.marker = L.marker([lat, lng], { draggable: true }).addTo(this.map);
                        this.circle = L.circle([lat, lng], {
                            radius: radius,
                            color: '#3b82f6',
                            fillOpacity: 0.1,
                        }).addTo(this.map);

                        this.marker.on('dragend', (e) => {
                            const pos = e.target.getLatLng();
                            this.updateLocation(pos.lat, pos.lng);
                        });

                        this.map.on('click', (e) => {
                            this.marker.setLatLng(e.latlng);
                            this.updateLocation(e.latlng.lat, e.latlng.lng);
                        });

                        this.$watch(() => this.$wire.get(radiusPath), (value) => {
                            if (this.circle) {
                                this.circle.setRadius(parseFloat(value) || 100);
                            }
                        });

                        setTimeout(() => this.map.invalidateSize(), 200);
                    },

                    updateLocation(lat, lng) {
                        lat = parseFloat(lat.toFixed(6));
                        lng = parseFloat(lng.toFixed(6));

                        this.$wire.set(latPath, lat);
                        this.$wire.set(lngPath, lng);

                        this.circle.setLatLng([lat, lng]);
                    }
                }
            }
        </script>
    @endpush
@endonce