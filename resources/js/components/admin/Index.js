import React from 'react';
import ReactDOM from 'react-dom';
import {
    BrowserRouter as Router
} from 'react-router-dom';

function Index() {
    return (
        <div className='container'>
            <h1>Hello world</h1>
        </div>
    );
}

export default Index;

if(document.getElementById('auth')) {
    ReactDOM.render(<Index />, document.getElementById('auth'));
}
