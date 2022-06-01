// components_use.js
// 根据需求引入项目中要使用的组件
import Vue from 'vue'
import VueCropper from 'vue-cropper'
import {
    Alert,
    Avatar,
    BackTop,
    Breadcrumb,
    Button,
    Card,
    Cascader,
    Checkbox,
    Col,
    ConfigProvider,
    DatePicker,
    Descriptions,
    Divider,
    Drawer,
    Dropdown,
    Form,
    FormModel,
    Icon,
    Input,
    InputNumber,
    Layout,
    List,
    Menu,
    message,
    Modal,
    notification,
    Pagination,
    Popconfirm,
    Popover,
    Progress,
    Radio,
    Row,
    Select,
    Spin,
    Steps,
    Table,
    Tag,
    TimePicker,
    Tooltip,
    Tree,
    Upload
} from 'ant-design-vue'


Vue.use(Layout)
Vue.use(Input)
Vue.use(InputNumber)
Vue.use(Button)
Vue.use(Radio)
Vue.use(Checkbox)
Vue.use(Select)
Vue.use(Cascader)
Vue.use(Card)
Vue.use(Form)
Vue.use(Row)
Vue.use(Col)
Vue.use(Modal)
Vue.use(Table)
Vue.use(Icon)
Vue.use(Popover)
Vue.use(Dropdown)
Vue.use(List)
Vue.use(Avatar)
Vue.use(Breadcrumb)
Vue.use(Steps)
Vue.use(Spin)
Vue.use(Menu)
Vue.use(Drawer)
Vue.use(Tooltip)
Vue.use(Alert)
Vue.use(Divider)
Vue.use(DatePicker)
Vue.use(TimePicker)
Vue.use(Upload)
Vue.use(Progress)
Vue.use(Popconfirm)
Vue.use(notification)
Vue.use(Pagination)
Vue.use(FormModel)
Vue.use(Tree)
Vue.use(Descriptions)
Vue.use(BackTop)
Vue.use(VueCropper)
Vue.use(Tag)
Vue.prototype.$confirm = Modal.confirm
Vue.prototype.$message = message
Vue.prototype.$notification = notification
Vue.prototype.$info = Modal.info
Vue.prototype.$success = Modal.success
Vue.prototype.$error = Modal.error
Vue.prototype.$warning = Modal.warning
Vue.component(ConfigProvider.name, ConfigProvider);