<template>
  <div id="map"></div>
</template>

<script>
import mapboxgl from 'mapbox-gl';

export default {
  name: 'mapbox-list',
  props: ['markers'],
  data() {
    return {
      token:
        'pk.eyJ1IjoiZ2FicmllbHJtcyIsImEiOiJjazFzbDJjeDMwaGE4M2VsaWI2c2Q3YXA4In0.oVcWJ0uwQQj5GfhXOUj66Q',
      map: {},
      geocoder: {},
      currentLocation: {
        longitude: -47.8823,
        latitude: -15.7934
      }
    };
  },

  methods: {
    getCurrentLocation() {
      navigator.geolocation.getCurrentPosition((position) => {
        this.startMap({
          latitude: position.coords.latitude,
          longitude: position.coords.longitude
        });
        this.loadLocations();
      });
    },

    startMap({ longitude, latitude }) {
      mapboxgl.accessToken = this.token;

      this.map = new mapboxgl.Map({
        container: document.querySelector('#map'),
        style: 'mapbox://styles/mapbox/streets-v11',
        center: [longitude, latitude], // (Longitude, Latitude)
        zoom: 12
      });

      this.configureGeolocation();
      this.configureControlsMap();
    },

    configureGeolocation() {
      this.geocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl,
        placeholder: 'Pesquise Ex: Brasil ...'
      });
      this.map.addControl(this.geocoder, 'top-left');
    },

    configureControlsMap() {
      this.map.addControl(new mapboxgl.NavigationControl());
      this.map.addControl(
        new mapboxgl.GeolocateControl({
          positionOptions: {
            enableHighAccuracy: true
          },
          trackUserLocation: true
        })
      );
    },

    loadLocations() {
      this.map.on('load', (e) => {
        if (e.type === 'load') this.renderMarkers();
      });
    },

    renderMarkers() {
      this.markers.map((e) => {
        let popup = new mapboxgl.Popup({ offset: 25 }).setHTML(`
            <h1>${e.nome}</h1><br>
            <p class="mb-0"><b>Contato:</b> ${e.telefone}</p>
            <p class="mb-0"><b>Endereço:</b> ${e.bairro}, ${e.logradouro}, ${e.complemento}.</p>
            <b>Para mais detalhes, </b><a href="http://localhost:8080/instituicao/${e.id}">acesse aqui!</a>
          `);

        new mapboxgl.Marker()
          .setLngLat([Number(e.longitude), Number(e.latitude)])
          .setPopup(popup)
          .addTo(this.map);
      });
    }
  },

  mounted() {
    setTimeout(() => this.getCurrentLocation(), 2000);
  }
};
</script>

<style scoped>
#map {
  top: 0;
  bottom: 0;
  width: 100%;
  height: 500px;
}
</style>
