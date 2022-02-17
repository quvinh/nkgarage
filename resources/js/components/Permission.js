import React, { useState, useEffect } from "react";
import axios from 'axios';
import { BrowserRouter as Router,
    Link } from 'react-router-dom';

function Permission() {
    const [data, setData] = useState([]);
    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/admin/auth_model/permission')
            .then(response => (
                setData(response.data)
            ))
    }, []);

    const handleDelete = (e, id) => {

        const eClick = e.currentTarget;
        // eClick.innerText = 'Deleting...';
        // tìm hieu json web tocken
        axios.delete('http://127.0.0.1:8000/api/admin/auth_model/permission/' + id)
        .then((res) => {
            console.log('Deleted Successfully');
            eClick.closest('tr').remove();
        }).catch((error) => {
            console.log(error);
        })
    }

    return (
        <div>
            <Link to={'/permission/add'} className='btn btn-info'>Add</Link>
            <br />
            <table className="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Note</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                    {
                        data.map(row => {
                            return (
                                <tr key={row.id}>
                                    <th scope="row">{row.id}</th>
                                    <td>{row.name}</td>
                                    <td>{row.note}</td>
                                    <td>
                                        <Link to={'/permission/edit/' + row.id} className='btn btn-primary'>Edit</Link>
                                        {/* <Link to={'/delete/' + row.id} className='btn btn-secondary'>Delete</Link> */}
                                        <button onClick={(e) => handleDelete(e, row.id)} className='btn btn-secondary'>Delete</button>
                                    </td>
                                </tr>
                            );
                        })
                    }
                </tbody>
            </table>
            
        </div>
    );
}

export default Permission;