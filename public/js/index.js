const map = new ol.Map({
  target: 'map',
  layers: [
    new ol.layer.Tile({
      source: new ol.source.XYZ({
        url: 'https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}',
        maxZoom: 19,
        attribution: ['Powered By Esri']
      })
    })
  ],
  view: new ol.View({
    center: new ol.proj.fromLonLat([ 110.3779112, -7.7701649 ]),
    zoom: 18,
    minZoom: 18,
  }),
  controls: new ol.control.defaults.defaults({
    attribution: false,
    zoom: false,
    rotate: false
  })
});

let markerLayer = new ol.layer.Vector({
  source: new ol.source.Vector()
})

let binProperties;

map.addLayer(markerLayer);

// pointermove event
map.on('pointermove', (event) => {
  const feature = map.forEachFeatureAtPixel(event.pixel, (feature) => feature)
  if (feature) {
    map.getTargetElement().style.cursor = 'pointer'
  } else {
    map.getTargetElement().style.cursor = ''
  }
})

// click event
map.on('click', (event) => {
  const feature = map.forEachFeatureAtPixel(event.pixel, (feature) => feature)
  if (feature) {
    binProperties = feature.getProperties()
    updatePopup()
    popup.classList.remove('popup-hidden')
    popup.classList.add('popup-show')
  } else {
    popup.classList.remove('popup-show')
    popup.classList.add('popup-hidden')
  }
})

map.getView().on('change:resolution', (event) => {
  const zoom = map.getView().getZoom()
  const features = markerLayer.getSource().getFeatures()
  if (zoom > 15) {
    features.forEach((feature) => {
      feature.getStyle().getText().setText(feature.get('name'))
    })
  } else {
    features.forEach((feature) => {
      feature.getStyle().getText().setText('')
    })
  }
})

function createMarker(id) {
  const positionMarker = new ol.Feature({
    geometry: new ol.geom.Point([0, 0]),
    name: id
  })
  
  const markerStyle = new ol.style.Style({
    image: new ol.style.Icon({
      src: './images/bin_not-connected.png',
      crossOrigin: 'anonymous',
      scale: 0.3
    }),
    stroke: new ol.style.Stroke({
      color: '#3399CC',
      width: 1.25
    }),
    text: new ol.style.Text({
      font: '16px Poppins,sans-serif',
      offsetY: -35,
      backgroundFill: new ol.style.Fill({ color: 'rgba(255,255,255,0.8)' }),
      backgroundStroke: new ol.style.Stroke({
        color: '#636363',
        width: 1.25
      }),
      padding: [2, 2, 2, 2],
    })
  })

  positionMarker.setStyle(markerStyle)
  positionMarker.setId(id)
  
  return positionMarker
}

function updatePopup() {
  // create initial value
  if(typeof binProperties === 'undefined') {
    binProperties = 0;
  }
  const popup = document.getElementById('popup');
  popup.innerHTML = Popup(binProperties);
}

async function updateMarker(bin) {
  if(bin.ID === '') {
    return;
  }

  const coordinate = ol.proj.fromLonLat([
    bin.Longitude,
    bin.Latitude
  ])

  // if marker exist
  const marker = markerLayer.getSource().getFeatureById(bin.ID)
  if(marker) {
    marker.getGeometry().setCoordinates(coordinate)
    marker.setProperties(bin)
    return
  }
  
  const newMarker = createMarker(bin.ID)
  newMarker.getGeometry().setCoordinates(coordinate)
  newMarker.setProperties(bin)

  markerLayer.getSource().addFeature(newMarker)
}

map.setView(new ol.View({
  center: map.getView().getCenter(),
  extent: map.getView().calculateExtent(map.getSize()),
  zoom: map.getView().getZoom()
}));

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
          <td>Waktu Ambil</td>
          <td>${bin.WaktuAmbil}</td>
        </tr>
        <tr>
          <td>Status</td>
          <td>${bin.Deskripsi}</td>
        </tr>
      </tbody>
    </table>
  `;
}
