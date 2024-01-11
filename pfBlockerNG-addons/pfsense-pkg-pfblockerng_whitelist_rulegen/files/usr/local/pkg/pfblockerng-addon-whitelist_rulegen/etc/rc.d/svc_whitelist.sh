#!/bin/sh

name="whitelister"
command="/usr/local/pkg/wildcard/venv/bin/python3"
log_file="/var/log/pfblockerng/dns_reply.log"
pidfile="/var/run/whitelist_monitor.pid"

# Starts the Whitelist Monitor
rc_start() {
    rc_stop

    if [ ! -f "${log_file}" ]; then
        echo "Log file ${log_file} not found, aborting start."
        /usr/bin/logger -p daemon.info -t service-whitelist \
            "Log file ${log_file} not found, aborting start."
        exit 1
    fi

    cd /usr/local/pkg/wildcard || exit
    ${command} -m whitelister &
    echo $! > "${pidfile}"

    pidnum=$(cat "${pidfile}")
    if [ -n "${pidnum}" ]; then
        echo "Whitelist Monitor started (PID: ${pidnum})"
        /usr/bin/logger -p daemon.info -t service-whitelist "Whitelist Monitor started"
    else
        echo "Whitelist Monitor failed to start"
        /usr/bin/logger -p daemon.info -t service-whitelist "Whitelist Monitor failed to Start"
    fi
}

# Stops the Whitelist Monitor
rc_stop() {
    if [ -f "${pidfile}" ]; then
        pidnum=$(cat "${pidfile}")
        if [ -n "${pidnum}" ]; then
            kill "${pidnum}" && rm -f "${pidfile}"
            echo "Whitelist Monitor stopped (PID: ${pidnum})"
            /usr/bin/logger -p daemon.info -t service-whitelist "Whitelist Monitor stopped"
        fi
    else
        echo "No PID file found, Whitelist Monitor may not be running."
    fi
}

# Displays the status of the Whitelist Monitor
rc_status() {
    if [ -f "${pidfile}" ]; then
        pidnum=$(cat "${pidfile}")
        if kill -0 "${pidnum}" 2>/dev/null; then
            echo "Whitelist Monitor is running (PID: ${pidnum})"
        else
            echo "Whitelist Monitor is not running"
        fi
    else
        echo "No PID file found, Whitelist Monitor is not running"
    fi
}

# Main Logic
case "$1" in
    start)
        rc_start
        ;;
    stop)
        rc_stop
        ;;
    restart)
        rc_stop
        rc_start
        ;;
    status)
        rc_status
        ;;
    *)
        echo "Usage: $0 {start|stop|restart|status}"
        exit 1
        ;;
esac
