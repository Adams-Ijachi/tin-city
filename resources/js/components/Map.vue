<script setup>
import { ref,onMounted ,onBeforeUnmount,computed} from 'vue'
import { GoogleMap,InfoWindow,CustomMarker } from 'vue3-google-map'


const vehicleLocations = ref([])
const eventSource = null;
const loading = ref(true);
const activeVehicle = ref(null);



const getVehicleLocation = () =>{

  const eventSource = new EventSource('/api/sse/vehicle-location');

  window.onbeforeunload = function () {
    eventSource.close();
  };

  eventSource.addEventListener('message', (e) => {
    const data = JSON.parse(e.data);
    if (data.status === 'success') {
      // loop through the data and update the marker position
      vehicleLocations.value = data.vehicle_locations;
      loading.value = false;
    }

    if (data.status === 'failure'){
      console.log('Error:', data.error);
      // alert("Something went wrong, please try again");
      loading.value = true;
    }

  });


};

const getPosition = (position) => {
  return {lat: parseFloat(position.latitude), lng: parseFloat(position.longitude)};
};


const mapCenter = computed(() => {
  if (vehicleLocations.value.length > 0) {
    return getPosition(vehicleLocations.value[0]);
  }
  return {lat: 9.896527, lng: 8.858331};
});

const infoWindowPosition = computed(() => {
  if (activeVehicle.value) {
    return getPosition(activeVehicle.value);
  }
  return {lat: 9.896527, lng: 8.858331};
});


onMounted(() => {
  getVehicleLocation();
});
onBeforeUnmount(() => {
  if (eventSource) {
    eventSource.close();
  }
});


</script>

<template>

<!--  // if loading is true show loading spinner-->
  <div v-if="loading === true" class="d-flex justify-content-center align-items-center" style="height: 440px">
    <div class="spinner-border text-primary" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
  </div>

  <GoogleMap
      v-if="loading === false"
      api-key=""
      style="width: 100%; height: 440px"
      :center="mapCenter"
      :zoom="15">

    <InfoWindow
        v-if="activeVehicle"
        :options="{
      position: infoWindowPosition,
      pixelOffset: {width: 0, height: -35},
      maxWidth: 200,
      // close other info windows when one is opened
      closeclick: () => {
        activeVehicle = null;
      }

    }">
      <div>
        <h2>Vehicle ID: <strong>{{activeVehicle.vehicleId}}</strong></h2>
        <h2>Vehicle Name:  <strong>{{activeVehicle.shortName}}</strong></h2>
        <h3>Address: <strong>{{activeVehicle.address}}</strong></h3>
      </div>
    </InfoWindow>


    <CustomMarker     v-for="vehicle in vehicleLocations"
                      @click="activeVehicle = vehicle"
                      :key="vehicle.vehicleId"
                      :options="{ position: getPosition(vehicle), label: vehicle.shortName,clickable: true,anchorPoint: 'BOTTOM_CENTER' }" >
      <div style="text-align: center">
        <div style="font-size: 1.125rem">{{vehicle.shortName}}</div>
        <img src="https://i.imgur.com/rTYcllA.png" width="50" height="50" style="margin-top: 8px" />
      </div>
    </CustomMarker>

  </GoogleMap>
</template>