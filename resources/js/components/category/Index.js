import axios from 'axios';
import React, { useEffect, useState } from 'react';
import { BrowserRouter as Router, Link } from 'react-router-dom';
import ReactDOM from 'react-dom';


function Index() {
    const [data, setData] = useState([])
    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/admin/category')
            .then(res => (
                setData({res: res.data.conversation})
            ))
    }, [])


    return (
        <div>
            <Link to={'/store'} className='btn btn-info'>Add</Link>
            <br />
            <table className='table'>
                <thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Name</th>
                        <th scope='col'>Note</th>
                        <th scope='col'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {
                        data.map(row => {
                            return (
                                <tr key={row.id}>
                                    <th scope='row'>{row.id}</th>
                                    <td>{row.name}</td>
                                    <td>{row.note}</td>
                                    <td>
                                        <Link to={'/update/' + row.id} className='btn btn-primary'>Edit</Link>
                                    </td>
                                </tr>
                            )
                        })
                    }
                </tbody>
            </table>
        </div>
    );
}

export default Index;

if (document.getElementById('category')) {
    ReactDOM.render(<Router><Index/></Router>, document.getElementById('category'));
}
