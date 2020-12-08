import Icon3Dots from "../icons/Icon3Dots";

class ActionMenu extends React.Component {

    componentDidMount() {
        this.initDropdowns();
    }

    initDropdowns = () => {
        // 3Dots
        if (!_.isUndefined(this.dropdownThreeDots)) {
            let dropdownThreeDots = $(this.dropdownThreeDots);
            dropdownThreeDots.dropdown();
        }
    }

    getTranslateUrl() {

    }

    getThreeDotsMenu = ()  => {
        return <div className={"action-submenu ui pointing top center floating dropdown"} id={"action-three-dots"}
                    ref={(dropdownThreeDots) => this.dropdownThreeDots = dropdownThreeDots}>
                    <Icon3Dots/>
                    <ul className="menu">
                        <li className="item" title="Revise" data-value="revise">
                            <a href={config.basepath+ "revise/" + config.pname + "/" +  config.source_code + "-" + config.target_code + "/" + config.id_job + "-" + config.password  }>Revise</a>
                        </li>
                        <li className="item" title="Translate" data-value="translate" >
                            <a href={config.basepath+ "translate/" + config.pname + "/" +  config.source_code + "-" + config.target_code + "/" + config.id_job + "-" + config.password  }>Translate</a>
                        </li>
                    </ul>
                </div>
    }


    render = () => {
        const {getThreeDotsMenu} = this;
        const threeDotsMenu = getThreeDotsMenu();

        return <div className={"action-menu qr-element"}>
                    {threeDotsMenu}
                </div>
    }
}


ActionMenu.defaultProps = {
};

export default ActionMenu ;