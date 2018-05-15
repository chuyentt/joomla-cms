<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Mapme
 * @author     Chuyen Trung Tran <chuyentt@gmail.com>
 * @copyright  2018 Chuyen Trung Tran
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');
$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_mapme') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'featureform.xml');
$canEdit    = $user->authorise('core.edit', 'com_mapme') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'featureform.xml');
$canCheckin = $user->authorise('core.manage', 'com_mapme');
$canChange  = $user->authorise('core.edit.state', 'com_mapme');
$canDelete  = $user->authorise('core.delete', 'com_mapme');
?>

<!-- Vị trí của hộp search -->
<input id="pac-input" class="controls" type="text" placeholder="Tìm ...">

<!-- Vị trí dành cho Map -->
<div id="map" class="map"></div>

<?php
$document   = JFactory::getDocument();
$language   = JFactory::getLanguage();

/**
* Lấy tham số thiết lập của component
* Hàm này sẽ chọn một số tham số cần thiết cho hiển thị bản đồ
*
* @param   mảng  &$params là một mảng chứa các tham số của component
*
* @return  mảng  Một mảng chứa các tham số cần thiết
*
*/
function getMapParams($params) {
	$mapapi = $params->get('map_api_key');
	if ($mapapi != 'YOUR_API_KEY' && strlen($mapapi) == 39) {
		$params = array(
			'center' => $params->get('center'),
			'zoom' => $params->get('zoom'),
			'maptypeid' => $params->get('maptypeid'),
			'styles' => $params->get('styles'),
			'header_height' => $params->get('header_height'),
			'height' => $params->get('height'),
			'map_api_key' => $mapapi,
			'firebase_config' => $params->get('firebase_config') // Nên kiểm tra điều kiện quyền để lấy giá trị này
		);
		return $params;
	} else {
		JError::raiseWarning( 100, 'No Google Maps API Key entered in your configuration' );
	}
}

/**
 * Thêm bản đồ vào view và làm việc với bản đồ
 * Hàm này sẽ lấy tham số thiết lập bản đồ từ hàm getMapParams để thiết lập
 *
 * @param   mảng  &$params là một mảng chứa các tham số cần thiết cho bản đồ
 * 
 * @return  mảng  Một mảng chứa các tham số cần thiết
 *
 */
function addMap($params) {
	$document = JFactory::getDocument();
	$assetUrl = JURI::root().'components/com_mapme/assets/';

	// Lấy dữ liệu tham số bản đồ để chuyển qua mã JavaScript (JS)
	$mapParams = getMapParams($params);
	
        // Lưu trữ các tham số từ php chuyển qua sử dụng trong JS
        // phía JS sử dụng: const params = Joomla.getOptions('params');
	$document->addScriptOptions('params', $mapParams);

	// Thêm định nghĩa style
	$document->addStyleSheet($assetUrl.'css/mapme.css');
        
        // Thêm mã JS để hiển thị bản đồ làm việc với bản đồ.
        // Lưu ý: ?v1.1 ở cuối đường dẫn URL là báo cho phía client biết
        // có sự thay đổi mã nguồn từ phía server. Nếu không thì những thay đổi
        // mã từ phía server sẽ không có hiệu lực vì cơ chế cache từ client.
        // Các thay đổi mã JS phần toàn cục: biến, hằng, hàm thì nên thêm phiên
        // bản ví dụ: ?v1.2, ?v1.3,... những thay đổi mã trong nội bộ của một
        // hàm trước đó thì không cần sửa phiên bản.
	$document->addScript($assetUrl.'js/mapme.js?v1.1');

	// Thêm Google Maps API
	$document->addScript('//maps.googleapis.com/maps/api/js?key='.$mapParams['map_api_key'].'&libraries=places,geometry,visualization&callback=initMap', true, true, true);
}

// Gọi hàm để thực thi những thay đổi
addMap($this->params);