var map;
var marker;
var infoWindow;
var messageWindow;

// Lấy giá tham số đã lưu từ Joomla
const params = Joomla.getOptions('params');

// Các phần tiếp theo làm theo các hướng dẫn trong tài liệu của Google Maps API

/**
* Data object
*/
var data = {
  title: null,
  lat: null,
  lng: null,
  properties: null
};

/*
 * Khởi tạo bản đồ theo &callback=initMap ở mapme.php
 */
function initMap() {
    var header_height = params.header_height + 'px';
    params.width = '100%';
    params.height = params.height ==='auto' || params.height ==='100%' ? 'calc(100vh - '+header_height+')':params.height + 'px';
    
    // Tìm đến phần tử HTML có id='map' để thiết lập kích thước cửa sổ bản đồ
    document.getElementById('map').style.width=params.width;
    document.getElementById('map').style.height=params.height;
    
    // Gọi hàm tạo bản đồ
    createMap(params);
    
    /*
     * Tạo bản đồ và thêm các sự kiện tương tác
     * @param mảng params chứa các tham số thiết lập bản đồ
     * @returns {undefined}
     */
    function createMap(params) {
        coords = params.center.split(',');
        center = new google.maps.LatLng(coords[0],coords[1]);
        var options = {
            center: center,
            zoom: parseInt(params.zoom),
            mapTypeId: params.maptypeid,
            styles: JSON.parse(params.styles),
            scrollwheel: 1,
            panControl: 1,
            mapTypeControl: 1,
            scaleControl: 1,
            zoomControl: 1
        };

        map = new google.maps.Map(document.getElementById('map'), options);

        infoWindow = new google.maps.InfoWindow;

        messageWindow = new google.maps.InfoWindow

        // Tạo một search box và liên kết tới giao diện theo id của HTML.
        var input = (document.getElementById("pac-input"));
        var searchBox = new google.maps.places.SearchBox((input));
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

        // Kiểm soát sự kiện tầm nhìn bản đồ thay đổi: pan, zoom để giới hạn khu 
        // vực tìm kiến theo tầm nhìn hiện tại trên bản đồ.
        map.addListener("bounds_changed", function() {
            searchBox.setBounds(map.getBounds());
        });
        
        var markers = [];
        // Listen for the event fired when the user selects a prediction and retrieve
        // more details for that place.

        // [START region_getplaces]
        // Listen for the event fired when the user selects an item from the
        // pick list. Retrieve the matching places for that item.
        searchBox.addListener("places_changed", function() {
            var places = searchBox.getPlaces();

            if (places.length === 0) {
                return;
            }

            // Clear out the old markers.
            markers.forEach(function(marker) {
                marker.setMap(null);
            });

            markers = [];

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();

            places.forEach(function(place) {
                if (!place.geometry) {
                    console.log("Returned place contains no geometry");
                    return;
                }
                var icon = {
                    url: place.icon,
                    size: new google.maps.Size(71, 71),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(17, 34),
                    scaledSize: new google.maps.Size(25, 25)
                };

                // Create a marker for each place.
                markers.push(new google.maps.Marker({
                    map: map,
                    icon: icon,
                    title: place.name,
                    position: place.geometry.location
                }));

                if (place.geometry.viewport) {
                    // Only geocodes have viewport.
                    bounds.union(place.geometry.viewport);
                } else {
                    bounds.extend(place.geometry.location);
                }
            });
            map.fitBounds(bounds);
        });
        // [END region_getplaces]

        // Kiểm soát sự kiện click chuột trên bản đồ
        map.addListener('click', function(e) {
            // Lấy giá trị tọa độ của vị trí click chuột
            data.lat = e.latLng.lat();
            data.lng = e.latLng.lng();
            
            // Truyền vào hàm addToDatabase
            addToDatabase(data);
        });
    }
}

/**
 * Xử lý dữ liệu click chuột
 * @param {đối tượng} data Dữ liệu theo cấu trúc được khai báo ở trên.
 * Nó chứa title, lat, lng và properties
 */
function addToDatabase(data) {
    // Test: Hiện thông báo tọa độ. Có thể bỏ dòng này khi test thành công
    alert(data.lat.toString().concat(",",data.lng.toString()));
    
    // Gọi hàm saveData
    return true;
};

function saveData() {
    
}