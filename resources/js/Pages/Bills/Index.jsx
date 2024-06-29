import React, { useEffect, useState } from "react";
import Layout from "../../components/Layout";
import Button from "react-bootstrap/Button";
import Modal from "react-bootstrap/Modal";
import { Box, Container, Switch, Typography } from "@mui/material";
import { DataGrid } from "@mui/x-data-grid";
import "notyf/notyf.min.css";
import Swal from "sweetalert2";
import axios from "axios";
import 'notyf/notyf.min.css';
import { Notyf } from 'notyf';

function Index({ bills }) {
    const [data, setData] = useState(bills);
    const notyf = new Notyf({
        duration: 1000,
        position: {
          x: 'right',
          y: 'top',
        },
        types: [
          {
            type: 'warning',
            background: 'orange',
            icon: {
              className: 'material-icons',
              tagName: 'i',
              text: 'warning'
            }
          },
          {
            type: 'error',
            background: 'indianred',
            duration: 2000,
            dismissible: true
          },
          {
            type: 'success',
            background: 'green',
            color: 'white',
            duration: 2000,
            dismissible: true
          },
          {
    
            type: 'info',
            background: '#24b3f0',
            color: 'white',
            duration: 1500,
            dismissible: false,
            icon: '<i class="bi bi-bag-check"></i>'
          }
        ]
      });
    const columns = [
        { field: 'id', headerName: 'ID', width: 70 },
        { field: 'name', headerName: 'Name', width: 200 },
        { field: 'phone', headerName: 'Phone', width: 150 },
        { field: 'address', headerName: 'Address', width: 250 },
        { field: 'email', headerName: 'Email', width: 250 },
        { field: 'total', headerName: 'Total', width: 130, type: 'number' },
        {
            field: 'status',
            headerName: "Status",
            width: 70,
            renderCell: (params) => (
                <Switch
                    checked={params.value == 1}
                    onChange={(e) => switchBill(params, e.target.checked ? 1 : 0)}
                    inputProps={{ 'aria-label': 'controlled' }}
                />
            )
        },
      ];
      const switchBill =(params, value)=>{
        axios.put('/bills/' + params.id, { status: value }).then((res) => {
            if (res.data.check == false) {
                if (res.data.msg) {
                    notyf.open({
                        type: 'error',
                        message: res.data.msg
                    });
                }
            } else if (res.data.check == true) {
                console.log(res.data);
                notyf.open({
                    type: 'success',
                    message: 'Chuyển trạng thái thành công'
                });
                setData(res.data.bills);
            }
        })
      }

    return (
        <Layout>
            <>
            <Box sx={{ height: 400, width: "100%" }}>
            <DataGrid
            rows={data}
            columns={columns}
            pageSize={5}
            checkboxSelection
            editMode="cell"
            initialState={{
                pagination: {
                    paginationModel: {
                        pageSize: 5,
                    },
                },
            }}
            pageSizeOptions={[5]}
            disableRowSelectionOnClick
          />
                 
            </Box>
            </>
        </Layout>
  
    );
}

export default Index;