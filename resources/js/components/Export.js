import axios from 'axios';
import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';

function Export() {
    const [data, setData] = useState([])
    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/admin/export')
            .then(res => (
                console.log(res.data.data),
                setData(res.data.data)
            )).catch(err => {
                console.log(err)
            })
    }, []);

    return (
        <div>
            <Link to={'/export/add'} className='btn btn-primary'>Add</Link>
            <br /><br />
            <table className='table'>
                <thead>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>Detail Item ID</th>
                        <th scope='col'>Amount</th>
                        <th scope='col'>Unit</th>
                        <th scope='col'>Status</th>
                        <th scope='col'>Note</th>
                        <th scope='col'>Created By</th>
                        <th scope='col'>Created At</th>
                        <th scope='col'>Updated At</th>
                        <th scope='col'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {
                        data.map(row => {
                            return (
                                <tr key={row.id}>
                                    <th scope='row'>{row.id}</th>
                                    <td>{row.detail_item_id}</td>
                                    <td>{row.amount}</td>
                                    <td>{row.unit}</td>
                                    <td>{row.status}</td>
                                    <td>{row.note}</td>
                                    <td>{row.created_by}</td>
                                    <td>{row.created_at}</td>
                                    <td>{row.updated_at}</td>
                                    <td>
                                        <Link to={'/export/edit/' + row.id} className='btn btn-primary'>Edit</Link>
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

export default Export;
