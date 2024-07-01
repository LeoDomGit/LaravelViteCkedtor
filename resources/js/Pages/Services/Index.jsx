import React, { useEffect, useState } from "react";
import Layout from "../../components/Layout";
import { Notyf } from "notyf";
import { Box, InputLabel, MenuItem, Switch, Typography } from "@mui/material";
import { DataGrid } from "@mui/x-data-grid";
import "notyf/notyf.min.css";

function Index() {
  const [create, setCreate] = useState(false);
  const resetCreate = () => {
    setCreate(true);
  };
  return (
    <Layout>
      <>
        <nav className="navbar navbar-expand-lg navbar-light bg-light">
          <div className="container-fluid">
            <button
              className="navbar-toggler"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent"
              aria-expanded="false"
              aria-label="Toggle navigation"
            >
              <span className="navbar-toggler-icon" />
            </button>
            <div
              className="collapse navbar-collapse"
              id="navbarSupportedContent"
            >
              <ul className="navbar-nav me-auto mb-2 mb-lg-0">
                <li className="nav-item">
                  <a
                    className="btn btn-primary"
                    onClick={(e) => resetCreate()}
                    aria-current="page"
                    href="#"
                  >
                    Tạo mới
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </nav>
        <div className="row mt-3">
          <div className="container">
            <div class="card text-start shadow-sm p-3 mb-5 bg-body rounded">
              <div class="card-body">
                <div className="row">
                  <div className="col-md-3">
                    <div className="input-group mb-3">
                      <span className="input-group-text">Tiêu đề</span>
                      <input
                        type="text"
                        className="form-control"
                        aria-label="Amount (to the nearest dollar)"
                      />
                    </div>
                  </div>
                  <div className="col-md-3">
                    <div className="input-group mb-3">
                      <span className="input-group-text">Tiêu đề</span>
                      <input
                        type="text"
                        className="form-control"
                        aria-label="Amount (to the nearest dollar)"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </>
    </Layout>
  );
}

export default Index;
