import axios from 'axios';
import React, { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';

function Detail_Item(props) {
    const [data, setData] = useState([])
    useEffect(() => {
        axios.get('http://127.0.0.1:8000/api/admin/detail_item')
        .then(res => {
            console.log(res)
            setData(res.data.data)
        }).catch(err => {
            console.log(err)
        })
    }, [])
    return (
        <div>
            <Link to={'/detail_item/add'} className='btn btn-primary' >Add</Link>
            <br/><br/>
            <table className='table'>
            <thead>
                    <tr>
                        <th scope='col'>Item ID</th>
                        <th scope='col'>Category ID</th>
                        <th scope='col'>Warehouse ID</th>
                        <th scope='col'>Shelf ID</th>
                        <th scope='col'>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {
                        data.map(row => {
                            return (
                                <tr key={row.item_id}>
                                    <th scope='row'>{row.item_id}</th>
                                    <td>{row.category_id}</td>
                                    <td>{row.warehouse_id}</td>
                                    <td>{row.shelf_id}</td>
                                    <td>
                                        <Link to={'/detail_item/edit/' + row.item_id} className='btn btn-primary'>Edit</Link>
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

export default Detail_Item;
