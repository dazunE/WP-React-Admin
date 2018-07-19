import React, {Component} from 'react';
import fetchWP from '../utils/fetchWP';
import { Tab, Tabs, TabList, TabPanel} from 'react-tabs';
import * as Icons from 'react-icons/lib/fa';
import Item from '../components/Infoitem';
import About from '../components/About';
import Aux from '../utils/Aux';


export default class Admin extends Component {

    constructor(props) {

        super(props);

        this.state = {
            serverInfo: '',
            wpInfo:''
        }

        this.fetchWP = new fetchWP({
            restURL: this.props.wpObject.api_url,
            restNonce: this.props.wpObject.api_nonce,
        });

        this.getSeverInfo();
        this.getWPInfo();

    }

    getSeverInfo = () => {
        this.fetchWP.get('server')
            .then(
                (json) => this.setState({
                    serverInfo: json
                }),
                (err) => console.log('error', err)
            );
    };

    getWPInfo = () =>{
        this.fetchWP.get('wpinfo')
            .then(
                (json) => this.setState({
                    wpInfo: json
                }),
                (err) => console.log('error', err)
            );
    }

    render() {

        const infoItems = Object.keys(this.state.serverInfo)
            .map(
                id => {
                    return (
                        <Aux key={id}>
                        <Item title={(this.state.serverInfo[id].name).split("_").join(" ")} content={this.state.serverInfo[id].value}/>
                        </Aux>
                    );
                });

        const wpinfoItems = Object.keys(this.state.wpInfo)
            .map(
                id => {
                    return (
                        <Aux key={id}>
                        <Item title={(this.state.wpInfo[id].name).split("_").join(" ")} content={this.state.wpInfo[id].value}/>
                        </Aux>
                    );
                });

        return (
            <div className="wrap">
                <h1>Server Information</h1>
                <Tabs>
                    <TabList>
                        <Tab><Icons.FaServer/>Server Configurations</Tab>
                        <Tab><Icons.FaWordpress/>WordPress Configurations</Tab>
                        <Tab><Icons.FaInfo/>About This Plugin</Tab>
                    </TabList>

                    <TabPanel>
                        {infoItems}
                    </TabPanel>
                    <TabPanel>
                        {wpinfoItems}
                    </TabPanel>
                    <TabPanel>
                        <About/>
                    </TabPanel>
                </Tabs>
            </div>
        );
    }
}
