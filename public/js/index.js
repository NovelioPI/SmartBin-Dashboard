const MIDDLE_MAP = [108.615920, -6.771561];
const FIRST_CORNER = [-6.782426, 108.618992];
const SECOND_CORNER = [-6.764578, 108.608111];

let binProperties;
let currentBin = 1;

const map = new ol.Map({
  target: 'map',
  layers: [
    new ol.layer.Tile({
      source: new ol.source.XYZ({
        url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
        maxZoom: 19,
        attribution: ['Powered By Esri'],
      })
    })
  ],
  view: new ol.View({
    center: new ol.proj.fromLonLat(MIDDLE_MAP),
    zoom: 18,
    minZoom: 18,
  }),
  controls: new ol.control.defaults.defaults({
    zoom: false,
    rotate: false,
  }),
});

const overlay = new ol.Overlay({
  element: pulse,
  position: [0, 0],
  positioning: 'center-center',
});

let markerLayer = new ol.layer.Vector({
  source: new ol.source.Vector(),
});

map.addLayer(markerLayer);
map.addOverlay(overlay);

// set map limit
map.once('postrender', (event) => {
  const farthest1 = map.getPixelFromCoordinate(FIRST_CORNER);
  const farthest2 = map.getPixelFromCoordinate(SECOND_CORNER);
  const extent = farthest2.map((point, index) => Math.abs(point - farthest1[index]) * 100000);

  map.setView(new ol.View({
    center: map.getView().getCenter(),
    extent: map.getView().calculateExtent(extent),
    zoom: map.getView().getZoom(),
  }));
});

// pointermove event
map.on('pointermove', (event) => {
  const marker = map.forEachFeatureAtPixel(event.pixel, (marker) => marker);
  if (marker) {
    map.getTargetElement().style.cursor = 'pointer';
  } else {
    map.getTargetElement().style.cursor = '';
  }
});

// click event
map.on('click', (event) => {
  const marker = map.forEachFeatureAtPixel(event.pixel, (marker) => marker)

  if (marker) {
    binProperties = marker.getProperties();
    currentBin = binProperties.ID;
    pulsatingMarker(binProperties);
    updatePopup();
    pulse.classList.add('pulsate');
    popup.classList.remove('popup-hidden');
    popup.classList.add('popup-show');
  } else {
    pulse.classList.remove('pulsate');
    popup.classList.remove('popup-show');
    popup.classList.add('popup-hidden');
  }
});

function setMarkerIcon(status) {
  let iconPath = './images/';
  switch (status) {
    case 'Tidak Terhubung': 
      iconPath = iconPath + 'bin_not-connected.png';
      break;
    case 'Kosong':
      iconPath = iconPath + 'bin_empty.png';
      break;
    case 'Setengah Penuh':
      iconPath = iconPath + 'bin_half-empty.png';
      break;
    case 'Penuh':
      iconPath = iconPath + 'bin_full.png';
      break;
  }

  return iconPath;
}

function setMarkerStyle(status) {
  const markerStyle = new ol.style.Style({
    image: new ol.style.Icon({
      src: setMarkerIcon(status),
      crossOrigin: 'anonymous',
      scale: 0.3,
    }),
  })

  return markerStyle;
}

function createMarker(bin) {
  const positionMarker = new ol.Feature({
    geometry: new ol.geom.Point([0, 0]),
    name: bin.ID,
  });
  
  const markerStyle = setMarkerStyle(bin.Deskripsi);
  positionMarker.setStyle(markerStyle);
  positionMarker.setId(bin.ID);

  return positionMarker;
}

function updatePopup() {
  const bin = markerLayer.getSource().getFeatureById(currentBin);
  if (bin) {
    const popup = document.getElementById('popup');
    popup.innerHTML = Popup(bin.getProperties());
  }
}

async function updateMarker(bin) {
  if(bin.ID === '') {
    return;
  }

  const coordinate = ol.proj.fromLonLat([
    bin.Longitude,
    bin.Latitude,
  ]);

  // if marker exist
  const marker = markerLayer.getSource().getFeatureById(bin.ID);
  if(marker) {
    marker.setStyle(setMarkerStyle(bin.Deskripsi));
    marker.getGeometry().setCoordinates(coordinate);
    marker.setProperties(bin);
    return;
  }

  const newMarker = createMarker(bin);
  newMarker.getGeometry().setCoordinates(coordinate);
  newMarker.setProperties(bin);

  markerLayer.getSource().addFeature(newMarker);
}

function Popup(bin) {
  return `
    <table class="table">
      <tbody>
        <tr>
          <td>Bin Id</id>
          <td>${bin.ID}</td>
        </tr>
        <tr>
          <td>Latitude</td>
          <td>${bin.Latitude}</td>
        </tr>
        <tr>
          <td>Longitude</td>
          <td>${bin.Longitude}</td>
        </tr>
        <tr>
          <td>Pembaruan Status</td>
          <td>${formatDate(bin.WaktuAmbil, 'date')}</td>
        </tr>
        <tr>
          <td>Waktu Pembaruan Status</td>
          <td>${formatDate(bin.WaktuAmbil, 'time')}</td>
        </tr>
        <tr>
          <td>Status</td>
          <td>${bin.Deskripsi}</td>
        </tr>
      </tbody>
    </table>
  `;
}

function pulsatingMarker(marker){
  const coordinates = new ol.proj.fromLonLat([marker.Longitude, marker.Latitude]);
  overlay.setPosition(coordinates);
}

function formatDate(date, type) {
  if (!date) {
    return;
  }

  const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
  const days = [ 'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

  const time = date.split(" ")[1];
  date = new Date(date);

  if (type == 'date') {
    return `${days[date.getDay()]}, ${date.getDate()} ${months[date.getMonth()]} ${date.getFullYear()}`;
  } else if (type == 'time') {
    return time;
  }
}