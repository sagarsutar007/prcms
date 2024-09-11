import React from "react";
import DataTable from "react-data-table-component";
import { format } from "date-fns";
import { useNavigate } from "react-router-dom";

// Helper function to determine the exam status
const getExamStatus = (startTime, endTime) => {
  const now = new Date();
  const examStart = new Date(startTime);
  const examEnd = new Date(endTime);

  if (now > examEnd) {
    return "Conducted";
  } else if (now >= examStart && now <= examEnd) {
    return "On-Going";
  } else if (now < examStart) {
    return "Upcoming";
  }
};

const ExamTable = ({ data }) => {
  const navigate = useNavigate();
  // Define columns for the data table
  const columns = [
    {
      name: "Sl.",
      cell: (row, index) => index + 1,
      sortable: false,
      width: "80px",
    },
    {
      name: "Exam Name",
      selector: (row) => row.name,
      sortable: true,
    },
    {
      name: "Date & Time",
      selector: (row) => format(new Date(row.exam_datetime), "dd-MM-yyyy hh:mm a"),
      sortable: true,
    },
    {
      name: "Duration",
      selector: (row) => `${row.duration} mins`,
      sortable: true,
    },
    {
      name: "Status",
      cell: (row) => getExamStatus(row.exam_datetime, row.exam_endtime),
      sortable: true,
    },
    {
      name: "Action",
      cell: (row) => {
        const status = getExamStatus(row.exam_datetime, row.exam_endtime);
        if (status === "Upcoming" || status === "On-Going") {
          return (
            <button
              className="btn btn-primary btn-sm"
              onClick={() => handleAction(row.url, "exam")}
            >
              Go to Exam
            </button>
          );
        } else if (status === "Conducted") {
          return (
            <button
              className="btn btn-success btn-sm"
              onClick={() => handleAction(row.url, "result")}
            >
              View Result
            </button>
          );
        }
      },
      sortable: false,
    },
  ];

  // Function to handle the action buttons (Go to Exam / View Result)
  const handleAction = (id, actionType) => {
    if (actionType === "exam") {
      navigate(`/exam/${id}`);
    } else if (actionType === "result") {
      navigate(`/exam/result/${id}`);
    }
  };

  // Define the custom pagination options
  const paginationOptions = {
    rowsPerPageText: "Rows per page",
    rangeSeparatorText: "of",
  };

  return (
    <DataTable
      columns={columns}
      data={data}
      pagination
      paginationComponentOptions={paginationOptions}
      fixedHeader
      highlightOnHover
      sortable
      defaultSortFieldId="id"
      className="table table-bordered table-striped table-responsive"
    />
  );
};

export default ExamTable;
