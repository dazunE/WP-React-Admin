import React from 'react';
import Info from 'react-icons/lib/fa/circle';

const Infoitem = ( props ) => (
    <div className="info-item">
        <span className="info-item_icon">
            <Info/>
        </span>
        <span className="info-item_title">
            { props.title }
        </span>
        <span>
            :
        </span>
        <span className="info-item_content">
            { props.content }
        </span>
    </div>
);

export default Infoitem;