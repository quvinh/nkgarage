import React, {useState, useEffect} from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';
import ReactDOM from 'react-dom';
import Header from './Header'
import {
    BrowserRouter as Router
} from 'react-router-dom';
import Login from './Login';
import Register from './data/Register';

function Index() {
    // const [data, setData] = useState([]);
    // useEffect(() => {
    //     axios.get('http://127.0.0.1:8000/api/auth')
    //         .then(res => (
    //             setData(res.data)
    //         ))
    // })
    return (
        <div className='container'>
            <Header />
            <Login />
            <Register />
            <table className='table'>
                <thead>
                    <tr>
                        <th scope="col">No.</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="col">1</th>
                        <td>abc</td>
                        <td>abc</td>
                        <td>abc</td>
                    </tr>
                </tbody>
            </table>
        </div>
    );
}

export default Index;

if(document.getElementById('auth')) {
    ReactDOM.render(<Router><Index /></Router>, document.getElementById('auth'));
}
