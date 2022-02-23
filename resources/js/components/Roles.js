import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Link } from 'react-router-dom';

function Roles() {
    const [data, setData] = useState([]);
    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/admin/auth_model/roles')
        .then(response => (
            setData(response.data)
        )) 
    }, []);

    const handleDelete = (e, id) => {
        const eClick = e.currentTarget;
        axios.delete('http://127.0.0.1:8000/api/delete/' +id)
        .then ((response) => {
            console.log('Deleted successfully');
            eClick.closest('tr').remove();
        }).catch((error)=>{
            console.log(error);
        })
    }

    return (
        <div>
            <Link to={'/roles/add'} className = 'btn btn-info'>Add</Link>
            <br/>

            <table className="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Node</th>
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
                                        <Link to={'/roles/edit/' + row.id} className='btn btn-primary'>Edit</Link>
                                        {/* <Link to={'/delete/' + row.id} className='btn btn-secondary'>Delete</Link> */}
                                        {/* <button onClick={(e) => handleDelete(e, row.id)} className='btn btn-secondary'>Delete</button> */}
                                    </td>
                                </tr>
                            )
                        })
                    }
                </tbody>
                
            </table>
        </div>
    )
}

export default Roles;
