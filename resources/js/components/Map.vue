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
      alert("Something went wrong, please try again");
      window.location.href = '/';
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
      :zoom="20">

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

    <CustomMarker  v-for="vehicle in vehicleLocations" @click="activeVehicle = vehicle" :key="vehicle.vehicleId"
                      :options="{ position: getPosition(vehicle), label: vehicle.shortName,clickable: true,anchorPoint: 'BOTTOM_CENTER' }" >
      <div style="text-align: center">
        <div style="font-size: 1.125rem">{{vehicle.shortName}}</div>
        <img src="https://i.imgur.com/rTYcllA.png" width="50" height="50" style="margin-top: 8px" />
      </div>
    </CustomMarker>

    <h1 v-if="vehicleLocations.length === 0" style="text-align: center; margin-top: 20px">No vehicle found</h1>
  </GoogleMap>

  <section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
      <div class="flex flex-col text-center w-full mb-20">
        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">Map</h1>
        <p class="lg:w-2/3 mx-auto leading-relaxed text-base">This is a map of the vehicle locations</p>
      </div>
    </div>
  </section>

  <table class="table-auto">
    <thead>
    <tr>
      <th>Vechicle Name</th>
      <th>Current Location</th>
    </tr>
    </thead>
    <tbody>
    <tr v-for="vehicle in vehicleLocations">
      <td>{{vehicle.shortName}}</td>
      <td>{{vehicle.address}}</td>
    </tr>


    </tbody>
  </table>
</template>