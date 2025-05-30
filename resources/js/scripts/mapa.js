import 'ol/ol.css';
import Map from 'ol/Map';
import View from 'ol/View';
import TileLayer from 'ol/layer/Tile';
import OSM from 'ol/source/OSM';
import { fromLonLat } from 'ol/proj';
import Feature from 'ol/Feature';
import Point from 'ol/geom/Point';
import VectorLayer from 'ol/layer/Vector';
import VectorSource from 'ol/source/Vector';
import Style from 'ol/style/Style';
import Icon from 'ol/style/Icon';

const mapContainer = document.getElementById('map');
    if (mapContainer) {
        const madridCoords = fromLonLat([-3.7038, 40.4168]);

        const marker = new Feature({
            geometry: new Point(madridCoords),
        });

        marker.setStyle(new Style({
            image: new Icon({
                anchor: [0.5, 1],
                src: 'https://cdn-icons-png.flaticon.com/512/684/684908.png',
                scale: 0.05,
            }),
        }));

        const vectorSource = new VectorSource({
            features: [marker],
        });

        const vectorLayer = new VectorLayer({
            source: vectorSource,
        });

        new Map({
            target: 'map',
            layers: [
                new TileLayer({ source: new OSM() }),
                vectorLayer
            ],
            view: new View({
                center: madridCoords,
                zoom: 13,
            }),
        });
    }